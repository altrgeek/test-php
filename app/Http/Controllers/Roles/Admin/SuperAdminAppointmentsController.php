<?php

namespace App\Http\Controllers\Roles\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles\SuperAdmin;
use App\Traits\HandlesAppointments;
use Illuminate\Http\Request;
use App\Models\Appointments\AdminSuperAdminAppointment;
use App\Models\Appointments\AppointmentMeta;
use App\Notifications\AppointmentReceived;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\ZoomMeetingTrait;
use App\Traits\GoogleMeetTrait;

class SuperAdminAppointmentsController extends Controller
{
    use HandlesAppointments, ZoomMeetingTrait, GoogleMeetTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $super_admins = SuperAdmin::all()->map(function (SuperAdmin $super_admin) {
            $user = $super_admin->user;
            $user->super_admin_id = $super_admin->id; // For new records

            return $user;
        });

        $appointments = $request
            ->user()
            ->admin
            ->superAdminAppointments()
            ->get();

        return view('roles.admin.appointments.super-admin.calendar', compact('appointments', 'super_admins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AppointmentMeta $appointment_meta)
    {
        // Validate necessary appointment data and admin reference
        $this->validateData($request, ['super_admin']);

        $admin = $request->user()->admin;

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
        $appointment = $admin
            ->superAdminAppointments()
            ->create($this->prepareData(
                $request,
                'admin',
                [
                    'super_admin_id'   => $request->super_admin_id,
                    'status'     => 'pending', // Bypass the payment process
                    // Generate the meeting link right away
                    'meeting_id' => $meeting_id,
                    'meeting_platform' => $request['meeting_platform'],
                ]
            ));

        if ($request['meeting_platform'] == "Zoom Meet") {

            $appointment_meta->create([
                'appointment_type' => 'SuperAdmin_admin',
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

        $super_admin = $appointment->superAdmin;

        // Notify super-admin about new appointment request
        $super_admin->user->notify(new AppointmentReceived($appointment));

        return redirect()
            ->route('admin.dashboard.appointments.super_admin')
            ->with('created', 'A new appointment was fixed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, AppointmentMeta $appointmentMeta)
    {
        $appointment = $request
            ->user()
            ->admin
            ->superAdminAppointments()
            ->with(['superAdmin'])
            ->findOrFail($id);

        $appointment_meta = $appointmentMeta->where([
            'appointment_type' => 'superAdmin_admin',
            'appointment_id' => $appointment->id,
        ])->value('meta_value');

        $appointment = $this->applyHelperProps(
            $appointment,
            $appointment->requested_by == 'super_admin', // Is received?
        );

        return view('roles.admin.appointments.super-admin.preview', compact('appointment_meta', 'appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $appointment = $request
            ->user()
            ->admin
            ->superAdminAppointments()
            ->findOrFail($id);

        if ($appointment->requested_by != 'admin')
            return redirect()
                ->route('admin.dashboard.appointments.super_admin')
                ->with('message', 'Only requested appointments are editable!');

        if ($appointment->isCompleted())
            return redirect()
                ->route('admin.dashboard.appointments.super_admin')
                ->with('message', 'An already completed session cannot be edited!');

        $appointment = $this->praseDateAndTime($appointment);

        return view('roles.admin.appointments.super-admin.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate necessary data
        $this->validateData($request);


        $appointment = $request
            ->user()
            ->admin
            ->superAdminAppointments()
            ->findOrFail($id);

        if ($appointment->requested_by != "admin")
            return redirect()
                ->back()
                ->with('message', 'Only requested appointments are editable!');

        $appointment->update($this->prepareData($request, 'admin'));

        return redirect()
            ->route('admin.dashboard.appointments.super_admin')
            ->with('updated', 'The appointment was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $appointment = $request
            ->user()
            ->admin
            ->superAdminAppointments()
            ->findOrFail($id);

        if ($appointment->requested_by != "admin")
            return redirect()
                ->back()
                ->with('message', 'Only requested appointments can be deleted!');

        $appointment->delete(); // Delete the appointment

        return redirect()
            ->route('admin.dashboard.appointments.super_admin')
            ->with('deleted', 'The appointment was deleted');
    }
}
