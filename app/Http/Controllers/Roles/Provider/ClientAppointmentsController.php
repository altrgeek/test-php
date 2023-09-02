<?php

namespace App\Http\Controllers\Roles\Provider;

use Exception;
use Illuminate\View\View;
use App\Models\Roles\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Mail\Appointment\Updated as AppointmentUpdated;
use App\Models\Appointments\AppointmentMeta;
use App\Models\Billing\BoughtPackages;
use App\Notifications\AppointmentDeclined;
use App\Notifications\AppointmentReceived;
use App\Notifications\AppointmentReviewed;
use App\Traits\ZoomMeetingTrait as TraitsZoomMeetingTrait;
use App\Traits\GoogleMeetTrait;
use App\Traits\HandlesAppointments;

class ClientAppointmentsController extends Controller
{
    use HandlesAppointments, TraitsZoomMeetingTrait, GoogleMeetTrait;

    /**
     * Show all requested/received client appointments for current provider
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $provider = $request->user()->provider;

        // For selecting clients
        $clients = $provider->clients->map(function (Client $client) {
            $user = $client->user;
            $user->client_id = $client->id; // For new records

            return $user;
        });

        $appointments = $provider->clientAppointments()->get();

        return view('roles.provider.appointments.client.calendar', compact('clients', 'appointments'));
    }

    /**
     * Creates new appointment of current provider with selected client
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, AppointmentMeta $appointment_meta): RedirectResponse
    {
        // This will automatically validate all data related to appointment
        // Also make sure that a valid `client_id` was provided and the record
        // exists in `clients` table
        $this->validateData($request, ['client']);

        $provider = $request->user()->provider;

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

        // This will automatically parse the input fields and convert them into
        // appropriate data types suitable for the database
        $appointment = $provider
            ->clientAppointments()
            ->create($this->prepareData($request, 'provider', [
                // We are confident that a request has a valid `client_id` as
                // have validated the data before
                'client_id'  => $request->client_id,
                // Bypass the payment process and mark the meeting for ready
                'status'     => 'pending',
                // Generate the meeting link right away
                'meeting_id' => $meeting_id,
                'meeting_platform' => $request['meeting_platform'],
            ]));

        if ($request['meeting_platform'] == "Zoom Meet") {

            $appointment_meta->create([
                'appointment_type' => 'provider_client',
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
                'appointment_type' => 'provider_client',
                'appointment_id' => $appointment->id,
                'meta_key' => 'google_credentials',
                'meta_value' => [
                    'join_url' => $google_Meet_url,
                ],
            ]);
        }

        $client = $appointment->client;

        // Notify client that new appointment has been fixed for them
        $client->user->notify(new AppointmentReceived($appointment));

        return redirect()
            ->route('provider.dashboard.appointments.client')
            ->with('created', 'A new appointment was fixed with the client');
    }

    /**
     * Show a single appointment
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id, AppointmentMeta $appointmentMeta): View
    {
        $appointment = $request
            ->user()
            ->provider
            ->clientAppointments()
            ->with(['client'])
            ->findOrFail($id);

        $appointment_meta = $appointmentMeta->where([
            'appointment_type' => 'provider_client',
            'appointment_id' => $appointment->id,
        ])->value('meta_value');

        $appointment = $this->applyHelperProps(
            $appointment,
            $appointment->requested_by == 'client', // Is received?
        );

        return view('roles.provider.appointments.client.preview', compact('appointment_meta', 'appointment'));
    }

    /**
     * Show the form for updating appointment data
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $appointment = $request
            ->user()
            ->provider
            ->clientAppointments()
            ->findOrFail($id);

        if ($appointment->isCompleted())
            return redirect()
                ->route('provider.dashboard.appointments.client')
                ->with('message', 'An already completed session cannot be edited!');

        if ($appointment->requested_by != 'provider')
            return redirect()
                ->route('provider.dashboard.appointments.client')
                ->with('message', 'Only requested appointments are editable!');

        $appointment = $this->praseDateAndTime($appointment);

        return view('roles.provider.appointments.client.edit', compact('appointment'));
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
            ->provider
            ->clientAppointments()
            ->findOrFail($id);

        if ($appointment->requested_by == "provider")
            return redirect()
                ->back()
                ->with('message', 'Only received appointments can be reviewed!');

        if (!$appointment->isBooked())
            return redirect()
                ->back()
                ->with('message', 'The selected appointment is not reviewable!');

        $appointment = $this->praseDateAndTime($appointment);

        $bought = $appointment->client->bought_packages;

        if ($bought)
            return view('roles.provider.appointments.client.review', compact('appointment', 'bought'));


        return view('roles.provider.appointments.client.review', compact('appointment'));
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

        $provider = $request->user()->provider;

        $appointment = $provider->clientAppointments()->findOrFail($id);

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

        if ($appointment->requested_by == "provider")
            return redirect()
                ->back()
                ->with('message', 'Only received appointments can be reviewed!');

        if (!$appointment->isBooked())
            return redirect()
                ->back()
                ->with('message', 'The selected appointment is not reviewable!');


        $get = BoughtPackages::where('client_id', $appointment->client->id)->get();

        $session = 0;

        foreach ($get as $sessions) {
            $session = $sessions->sessions;
        }

        if ($appointment->client->bought_packages && $session != 0) {

            $subtract_session = $session - 1;

            $appointment->client->bought_packages()
                ->update([
                    "sessions" => $subtract_session,
                ]);

            DB::transaction(function () use ($request, $appointment, $meeting_id) {
                // Update appointment status
                $appointment->update($this->prepareData(
                    $request,
                    'client',
                    // Reviewed, waiting for client to complete payment
                    [
                        'status' => 'pending',
                        'meeting_id' => $meeting_id,
                        'meeting_platform' => $request['meeting_platform'],
                    ]
                ));
            });

            if ($request['meeting_platform'] == "Zoom Meet") {

                $appointment_meta->create([
                    'appointment_type' => 'provider_client',
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
                    'appointment_type' => 'provider_client',
                    'appointment_id' => $appointment->id,
                    'meta_key' => 'google_credentials',
                    'meta_value' => [
                        'join_url' => $google_Meet_url,
                    ],
                ]);
            }

            $client = $appointment->client;
            // Notify client that their request has been reviewed
            $client->user->notify(new AppointmentReviewed($appointment));

            // Appointment is reviewed
            return redirect()
                ->route('provider.dashboard.appointments.client')
                ->with('updated', 'The client appointment request has been reviewed!');
        }

        // Request must contain a price
        $request->validate([
            'price' => ['required', 'integer', 'min:1']
        ]);

        DB::transaction(function () use ($request, $appointment, $meeting_id) {
            // Update appointment status
            $appointment->update($this->prepareData(
                $request,
                'client',
                // Reviewed, waiting for client to complete payment
                [
                    'status' => 'reviewed',
                    'meeting_id' => $meeting_id,
                    'meeting_platform' => $request['meeting_platform'],
                ]
            ));

            // Create new order for the client
            $appointment
                ->client
                ->orders() // The event handlers will send receipt to user
                ->create([
                    'amount'         => $request->price,
                    'appointment_id' => $appointment->id,
                ]);
        });

        if ($request['meeting_platform'] == "Zoom Meet") {

            $appointment_meta->create([
                'appointment_type' => 'provider_client',
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
                'appointment_type' => 'provider_client',
                'appointment_id' => $appointment->id,
                'meta_key' => 'google_credentials',
                'meta_value' => [
                    'join_url' => $google_Meet_url,
                ],
            ]);
        }

        $client = $appointment->client;

        // Notify client that their request has been reviewed
        $client->user->notify(new AppointmentReviewed($appointment));

        // Appointment is reviewed and order has been created
        return redirect()
            ->route('provider.dashboard.appointments.client')
            ->with('updated', 'Invoice has been sent to the client!');
    }

    /**
     * Provider can only update their requested/created appointments
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate necessary data
        $this->validateData($request);

        $provider = $request->user()->provider;

        $appointment = $provider
            ->clientAppointments()
            ->findOrFail($id);

        if ($appointment->requested_by != "provider")
            return redirect()
                ->back()
                ->with('message', 'Only requested appointments are editable!');

        $appointment->update($this->prepareData(
            $request,
            'provider'
        ));

        $client = $appointment->client;

        // Notify client that appointment has been updated
        try {
            Mail::to($client->user->email)
                ->send(new AppointmentUpdated(
                    $appointment,
                    $provider->user
                ));
        } catch (Exception $error) {
            Log::critical('Could not notify client about updated appointment', [
                'appointment' => $appointment,
                'email' => $client->user->email,
                'error' => $error->getMessage()
            ]);
        }

        return redirect()
            ->route('provider.dashboard.appointments.client')
            ->with('updated', 'The appointment was updated');
    }

    /**
     * Declines appointment received from client
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline(Request $request, int $id): RedirectResponse
    {
        $provider = $request->user()->provider;

        // Provider can only decline received appointments from clients and if
        // they try to update an appointment which either does not come from
        // their client or was requested by themselves then this will result
        // in a 404 error
        $appointment = $provider->clientAppointments()->findOrFail($id);

        if ($appointment->requested_by == 'provider')
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

        $client = $appointment->client;

        // Notify client that their request has been declined
        $client->user->notify(new AppointmentDeclined($appointment));

        return redirect()
            ->route('provider.dashboard.appointments.client')
            ->with('updated', 'The appointment request was declined');
    }

    /**
     * Provider can any time delete only their requested appointments
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $appointment = $request
            ->user()
            ->provider
            ->clientAppointments()
            ->findOrFail($id);

        if ($appointment->requested_by != 'provider')
            return redirect()
                ->back()
                ->with('message', 'Received appointments can be declined only!');

        $appointment->delete(); // Delete the appointment

        return redirect()
            ->route('provider.dashboard.appointments.client')
            ->with('deleted', 'The appointment was deleted');
    }
}
