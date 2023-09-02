<?php

namespace App\Http\Controllers\Roles\Client;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\HandlesAppointments;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Models\Appointments\AppointmentMeta;
use App\Notifications\AppointmentReceived;

class AppointmentsController extends Controller
{
    use HandlesAppointments;

    /**
     * Show all requested/received appointments for current client
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {      
        $appointments = $request->user()->client->appointments;
        return view('roles.client.appointments.calendar', compact('appointments'));
    }

    /**
     * Creates new appointment of current client with their provider
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // This will automatically validate all data related to appointment
        $this->validateData($request);

        $client = $request->user()->client;
        $provider = $client->provider;

        // This will automatically parse the input fields and convert them into
        // appropriate data types suitable for the database
        $appointment = $client
            ->appointments()
            ->create($this->prepareData(
                $request,
                'client', // Requested from the client
                ['provider_id' => $provider->id] // Additional fields
            ));

        // Notify provider about new appointment request
        $provider->user->notify(new AppointmentReceived($appointment));

        return redirect()
            ->route('client.dashboard.appointments')
            ->with('created', 'A new appointment request was created');
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
            ->client
            ->appointments()
            ->with(['provider'])
            ->findOrFail($id);

        $appointment_meta = $appointmentMeta->where([
            'appointment_type' => 'provider_client',
            'appointment_id' => $appointment->id,
        ])->value('meta_value');

        $appointment = $this->applyHelperProps(
            $appointment,
            $appointment->requested_by == 'provider', // Is received?
        );

        return view('roles.client.appointments.preview', compact('appointment_meta', 'appointment'));
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
            ->client
            ->appointments()
            ->findOrFail($id);


        if (!$appointment->isBooked())
            return redirect()
                ->route('client.dashboard.appointments')
                ->with('message', 'Only non-reviewed appointments are editable!');

        if ($appointment->requested_by != 'client')
            return redirect()
                ->route('client.dashboard.appointments.')
                ->with('message', 'Only requested appointments are editable!');

        if ($appointment->isCompleted())
            return redirect()
                ->route('client.dashboard.appointments')
                ->with('message', 'An already completed session cannot be edited!');

        $appointment = $this->praseDateAndTime($appointment);

        return view('roles.client.appointments.edit', compact('appointment'));
    }

    /**
     * Updates specified appointment for current client with applied checks
     * including ownership verification and content editable locks
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // This will automatically validate all data related to appointment
        $this->validateData($request);

        $appointment = $request
            ->user()
            ->client
            ->appointments()
            ->findOrFail($id);

        if (!$appointment->isBooked())
            return redirect()
                ->route('client.dashboard.appointments')
                ->with('message', 'Only non-reviewed appointments are editable!');

        if ($appointment->requested_by != "client")
            return redirect()
                ->back()
                ->with('message', 'Received appointments are not editable!');

        $appointment->update($this->prepareData($request, 'client'));

        return redirect()
            ->route('client.dashboard.appointments')
            ->with('updated', 'Your appointment was updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $appointment = $request
            ->user()
            ->client
            ->appointments()
            ->findOrFail($id);

        if ($appointment->requested_by != "client")
            return redirect()
                ->back()
                ->with('message', 'Only requested appointments can be deleted!');

        if (!$appointment->isBooked())
            return redirect()
                ->back()
                ->with('message', 'Reviewed appointments can not be deleted!');

        $appointment->delete(); // Delete the appointment

        return redirect()
            ->route('client.dashboard.appointments')
            ->with('deleted', 'The appointment was deleted');
    }
}
