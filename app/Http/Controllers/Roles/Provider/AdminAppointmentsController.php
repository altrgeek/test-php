<?php

namespace App\Http\Controllers\Roles\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\HandlesAppointments;
use App\Models\Appointments\AppointmentMeta;
use App\Notifications\AppointmentReceived;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminAppointmentsController extends Controller
{
    use HandlesAppointments;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $appointments = $request
            ->user()
            ->provider
            ->adminAppointments;

        return view('roles.provider.appointments.admin.calendar', compact('appointments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate necessary appointment data and admin reference
        $this->validateData($request);

        $provider = $request->user()->provider;

        // Inject appropriate fields from validated request and pass some
        // additional fields
        $appointment = $provider
            ->adminAppointments()
            ->create($this->prepareData(
                $request,
                'provider',
                ['admin_id' => $provider->admin->id]
            ));

        $admin = $appointment->admin;

        // Notify admin about new appointment request
        $admin->user->notify(new AppointmentReceived($appointment));

        return redirect()
            ->route('provider.dashboard.appointments.admin')
            ->with('created', 'A new appointment was requested');
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
            ->provider
            ->adminAppointments()
            ->with(['admin'])
            ->findOrFail($id);

        $appointment_meta = $appointmentMeta->where([
            'appointment_type' => 'admin_provider',
            'appointment_id' => $appointment->id,
        ])->value('meta_value');

        $appointment = $this->applyHelperProps(
            $appointment,
            $appointment->requested_by == 'admin', // Is received?
        );

        return view('roles.provider.appointments.admin.preview', compact('appointment_meta', 'appointment'));
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
            ->provider
            ->adminAppointments()
            ->findOrFail($id);

        if (!$appointment->isBooked())
            return redirect()
                ->route('provider.dashboard.appointments.admin')
                ->with('message', 'Only non-reviewed appointments are editable!');

        if ($appointment->requested_by != 'provider')
            return redirect()
                ->route('provider.dashboard.appointments.admin')
                ->with('message', 'Only requested appointments are editable!');

        if ($appointment->isCompleted())
            return redirect()
                ->route('provider.dashboard.appointments.admin')
                ->with('message', 'An already completed session cannot be edited!');

        $appointment = $this->praseDateAndTime($appointment);

        return view('roles.provider.appointments.admin.edit', compact('appointment'));
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
            ->provider
            ->adminAppointments()
            ->findOrFail($id);

        if (!$appointment->isBooked())
            return redirect()
                ->route('provider.dashboard.appointments.admin')
                ->with('message', 'Only non-reviewed appointments are editable!');

        if ($appointment->requested_by != "provider")
            return redirect()
                ->back()
                ->with('message', 'Received appointments are not editable!');

        $appointment->update($this->prepareData($request, 'provider'));

        return redirect()
            ->route('provider.dashboard.appointments.admin')
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
            ->provider
            ->adminAppointments()
            ->findOrFail($id);

        if ($appointment->requested_by != "provider")
            return redirect()
                ->back()
                ->with('message', 'Only requested appointments can be deleted!');

        if (!$appointment->isBooked())
            return redirect()
                ->back()
                ->with('message', 'Reviewed appointments can not be deleted!');

        $appointment->delete(); // Delete the appointment

        return redirect()
            ->route('provider.dashboard.appointments.admin')
            ->with('deleted', 'The appointment was deleted');
    }
}
