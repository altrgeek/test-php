<?php

namespace App\Http\Controllers\Roles\Admin;

use Illuminate\Http\Request;
use App\Models\Roles\Provider;
use App\Traits\HandlesAppointments;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Mail\Appointment\Updated as AppointmentUpdated;
use App\Models\Appointments\AppointmentMeta;
use App\Notifications\AppointmentDeclined;
use App\Notifications\AppointmentReceived;
use App\Notifications\AppointmentReviewed;
use App\Traits\ZoomMeetingTrait;
use App\Traits\GoogleMeetTrait;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProviderAppointmentsController extends Controller
{
    use HandlesAppointments, ZoomMeetingTrait, GoogleMeetTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $providers = Provider::all()->map(function (Provider $provider) {
            $user = $provider->user;
            $user->provider_id = $provider->id; // For new records

            return $user;
        });

        $appointments = $request
            ->user()
            ->admin
            ->providerAppointments()
            ->get();

        return view('roles.admin.appointments.provider.calendar', compact('appointments', 'providers'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AppointmentMeta $appointment_meta)
    {
        // Validate necessary appointment data and provider reference
        $this->validateData($request, ['provider']);

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
            ->providerAppointments()
            ->create($this->prepareData(
                $request,
                'admin',
                [
                    'provider_id' => $request->provider_id,
                    'status'      => 'pending', // Bypass the payment process
                    // Generate the meeting link right away
                    'meeting_id' => $meeting_id,
                    'meeting_platform' => $request['meeting_platform'],
                ]
            ));

        if ($request['meeting_platform'] == "Zoom Meet") {

            $appointment_meta->create([
                'appointment_type' => 'admin_provider',
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
                'appointment_type' => 'admin_provider',
                'appointment_id' => $appointment->id,
                'meta_key' => 'google_credentials',
                'meta_value' => [
                    'join_url' => $google_Meet_url,
                ],
            ]);
        }

        $provider = $appointment->provider;

        // Notify provider that new appointment has been fixed for them
        $provider->user->notify(new AppointmentReceived($appointment));

        return redirect()
            ->route('admin.dashboard.appointments.provider')
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
            ->providerAppointments()
            ->with(['provider'])
            ->findOrFail($id);

        $appointment_meta = $appointmentMeta->where([
            'appointment_type' => 'admin_provider',
            'appointment_id' => $appointment->id,
        ])->value('meta_value');

        $appointment = $this->applyHelperProps(
            $appointment,
            $appointment->requested_by == 'provider', // Is received?
        );

        return view('roles.admin.appointments.provider.preview', compact('appointment_meta', 'appointment'));
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
            ->providerAppointments()
            ->findOrFail($id);

        if ($appointment->isCompleted())
            return redirect()
                ->route('admin.dashboard.appointments.provider')
                ->with('message', 'An already completed session cannot be edited!');

        if ($appointment->requested_by != 'admin')
            return redirect()
                ->route('admin.dashboard.appointments.provider')
                ->with('message', 'Only requested appointments are editable!');

        $appointment = $this->praseDateAndTime($appointment);

        return view('roles.admin.appointments.provider.edit', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reviewForm(Request $request, $id)
    {
        $appointment = $request
            ->user()
            ->admin
            ->providerAppointments()
            ->findOrFail($id);

        if ($appointment->requested_by == "admin")
            return redirect()
                ->back()
                ->with('message', 'Only received appointments can be reviewed!');

        if (!$appointment->isBooked())
            return redirect()
                ->back()
                ->with('message', 'The selected appointment is not reviewable!');

        $appointment = $this->praseDateAndTime($appointment);

        return view('roles.admin.appointments.provider.review', compact('appointment'));
    }

    /**
     * Review a received appointment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function review(Request $request, $id, AppointmentMeta $appointment_meta)
    {
        // Validate necessary data
        $this->validateData($request);

        $admin = $request->user()->admin;

        $appointment = $admin->providerAppointments()->findOrFail($id);

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

        if ($appointment->requested_by == "admin")
            return redirect()
                ->back()
                ->with('message', 'Only received appointments can be reviewed!');

        if (!$appointment->isBooked())
            return redirect()
                ->back()
                ->with('message', 'The selected appointment is not reviewable!');

        $appointment->update($this->prepareData(
            $request,
            'provider',
            [
                'status'      => 'pending', // Mark as ready
                // Generate the meeting ID
                'meeting_id' => $meeting_id,
                'meeting_platform' => $request['meeting_platform'],
            ]
        ));

        if ($request['meeting_platform'] == "Zoom Meet") {

            $appointment_meta->create([
                'appointment_type' => 'admin_provider',
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
                'appointment_type' => 'admin_provider',
                'appointment_id' => $appointment->id,
                'meta_key' => 'google_credentials',
                'meta_value' => [
                    'join_url' => $google_Meet_url,
                ],
            ]);
        }

        $provider = $appointment->provider;

        // Notify provider that their request has been reviewed
        $provider->user->notify(new AppointmentReviewed($appointment));

        return redirect()
            ->route('admin.dashboard.appointments.provider')
            ->with('updated', 'The appointment was reviewed');
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

        $admin = $request->user()->admin;

        $appointment = $admin->providerAppointments()->findOrFail($id);

        if ($appointment->requested_by != "admin")
            return redirect()
                ->back()
                ->with('message', 'Only requested appointments are editable!');

        $appointment->update($this->prepareData(
            $request,
            'admin'
        ));

        $provider = $appointment->provider;

        // Notify provider that appointment has been updated
        try {
            Mail::to($provider->user->email)
                ->send(new AppointmentUpdated(
                    $appointment,
                    $admin->user
                ));
        } catch (Exception $error) {
            Log::critical('Could not notify provider about updated appointment', [
                'appointment' => $appointment,
                'email' => $provider->user->email,
                'error' => $error->getMessage()
            ]);
        }

        return redirect()
            ->route('admin.dashboard.appointments.provider')
            ->with('updated', 'The appointment was updated');
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
        $admin = $request->user()->admin;

        $appointment = $admin->providerAppointments()->findOrFail($id);

        if ($appointment->requested_by == 'admin')
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

        $provider = $appointment->provider;

        // Notify provider that their request has been declined
        $provider->user->notify(new AppointmentDeclined($appointment));

        return redirect()
            ->route('admin.dashboard.appointments.provider')
            ->with('updated', 'The appointment request was declined');
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
            ->providerAppointments()
            ->findOrFail($id);

        $appointment->delete(); // Delete the appointment

        return redirect()
            ->route('admin.dashboard.appointments.provider')
            ->with('deleted', 'The appointment was deleted');
    }
}
