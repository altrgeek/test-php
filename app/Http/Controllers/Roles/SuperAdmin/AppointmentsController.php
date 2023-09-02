<?php

namespace App\Http\Controllers\Roles\SuperAdmin;

use Exception;
use Illuminate\View\View;
use App\Models\Roles\Admin;
use Illuminate\Http\Request;
use App\Traits\HandlesAppointments;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Mail\Appointment\Updated as AppointmentUpdated;
use App\Models\Appointments\AppointmentMeta;
use App\Notifications\AppointmentDeclined;
use App\Notifications\AppointmentReceived;
use App\Traits\ZoomMeetingTrait;
use App\Traits\GoogleMeetTrait;

class AppointmentsController extends Controller
{
    use HandlesAppointments, ZoomMeetingTrait, GoogleMeetTrait;

    /**
     * Display all appointments
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $admins = Admin::all()->map(function (Admin $admin) {
            $user = $admin->user;
            $user->admin_id = $admin->id; // For new records

            return $user;
        });

        $appointments = $request
            ->user()
            ->superAdmin
            ->appointments()
            ->get();

        return view('roles.super-admin.appointments.calendar', compact('appointments', 'admins'));
    }

    /**
     * Save the passed appointment data
     *
     * @param  \Illuminate\Http\Request  $request

     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, AppointmentMeta $appointment_meta): RedirectResponse
    {
        // Validate necessary appointment data and admin reference
        $this->validateData($request, ['admin']);

        $super_admin = $request->user()->superAdmin;

        if ($request['meeting_platform'] == "Cognimeet") {

            $meeting_id = $this->generateMeetingId();
        } elseif ($request['meeting_platform'] == "Zoom Meet") {

            $zoom = $this->create($request);

            $meeting_id = $zoom['data']['id'];

            $join_url = $zoom['data']['join_url'];
            $start_url = $zoom['data']['start_url'];
            $zoom_password = $zoom['data']['password'];
        } elseif ($request['meeting_platform'] == "Google Meet") {

            $google = $this->getClient($request);

            $meeting_id = $google['id'];
            $google_Meet_url = $google['hangoutLink'];
        }

        // Inject appropriate fields from validated request and pass some
        // additional fields
        $appointment = $super_admin
            ->appointments()
            ->create($this->prepareData(
                $request,
                'super_admin',
                [
                    'admin_id'   => $request->admin_id,
                    'status'     => 'pending', // Bypass the payment process
                    // Generate the meeting link right away
                    'meeting_id' => $meeting_id,
                    'meeting_platform' => $request['meeting_platform'],
                ]
            ));

        if ($request['meeting_platform'] == "Zoom Meet") {

            $appointment_meta->create([
                'appointment_type' => 'superAdmin_admin',
                'appointment_id' => $appointment->id,
                'meta_key' => 'zoom_credentials',
                'meta_value' => [
                    'zoom_password' => $zoom_password,
                    'join_url' => $join_url,
                    'start_url' => $start_url,
                ],
            ]);
        } elseif ($request['meeting_platform'] == "Google Meet") {
            $appointment_meta->create([
                'appointment_type' => 'superAdmin_admin',
                'appointment_id' => $appointment->id,
                'meta_key' => 'google_credentials',
                'meta_value' => [
                    'join_url' => $google_Meet_url,
                ],
            ]);
        }

        $admin = $appointment->admin;

        // Notify admin that new appointment has been fixed for them
        $admin->user->notify(new AppointmentReceived($appointment));

        return redirect()
            ->route('super_admin.dashboard.appointments')
            ->with('created', 'A new appointment was fixed');
    }

    /**
     * Show the the details of an appointment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id, AppointmentMeta $appointmentMeta): View
    {
        $appointment = $request
            ->user()
            ->superAdmin
            ->appointments()
            ->with(['admin'])
            ->findOrFail($id);

        $appointment_meta = $appointmentMeta->where([
            'appointment_type' => 'superAdmin_admin',
            'appointment_id' => $appointment->id,
        ])->value('meta_value');

        $appointment = $this->applyHelperProps(
            $appointment,
            $appointment->requested_by == 'admin', // Is received?
        );

        return view('roles.super-admin.appointments.preview', compact('appointment_meta', 'appointment'));
    }

    /**
     * Show the form for updating appointment data
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, $id): View
    {
        $appointment = $request
            ->user()
            ->superAdmin
            ->appointments()
            ->findOrFail($id);


        if ($appointment->isCompleted())
            return redirect()
                ->route('super_admin.dashboard.appointments')
                ->with('message', 'An already completed session cannot be edited!');

        $appointment = $this->praseDateAndTime($appointment);

        return view('roles.super-admin.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified appointment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id

     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validate necessary data
        $this->validateData($request);

        $super_admin = $request->user()->superAdmin;

        $appointment = $super_admin->appointments()->findOrFail($id);

        if ($appointment->requested_by != "super_admin")
            return redirect()
                ->back()
                ->with('message', 'Only requested appointments are editable!');

        $appointment->update($this->prepareData(
            $request,
            // Super-admin can edit all appointments
            $appointment->requested_by
        ));

        $admin = $appointment->admin;

        // Notify client that appointment has been updated
        try {
            Mail::to($admin->user->email)
                ->send(new AppointmentUpdated(
                    $appointment,
                    $super_admin->user
                ));
        } catch (Exception $error) {
            Log::critical('Could not notify admin about updated appointment', [
                'appointment' => $appointment,
                'email' => $admin->user->email,
                'error' => $error->getMessage()
            ]);
        }

        return redirect()
            ->route('super_admin.dashboard.appointments')
            ->with('updated', 'The appointment was updated!');
    }

    /**
     * Decline a received request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id

     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline(Request $request, $id): RedirectResponse
    {
        $super_admin = $request->user()->superAdmin;

        $appointment = $super_admin
            ->appointments()
            ->findOrFail($id);

        if ($appointment->requested_by == 'super_admin')
            return redirect()
                ->back()
                ->with('message', 'Only received appointments can be declined!');

        if ($appointment->isCompleted())
            return redirect()
                ->back()
                ->with('message', 'Already completed appointments cannot be declined!');

        if ($appointment->isDeclined())
            return redirect()
                ->back()
                ->with('message', 'Selected appointment is already declined!');

        $appointment->update([
            'status'     => 'declined',
            'meeting_id' => null
        ]);

        $admin = $appointment->admin;

        // Notify amin that their request has been declined
        $admin->user->notify(new AppointmentDeclined($appointment));

        return redirect()
            ->route('super_admin.dashboard.appointments')
            ->with('updated', 'The appointment was declined');
    }

    /**
     * Super admin can remove any appointment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $appointment = $request
            ->user()
            ->superAdmin
            ->appointments()
            ->findOrFail($id);

        $appointment->delete(); // Delete the appointment

        return redirect()
            ->route('super_admin.dashboard.appointments')
            ->with('deleted', 'The appointment was deleted');
    }
}
