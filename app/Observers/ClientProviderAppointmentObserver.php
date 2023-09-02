<?php

namespace App\Observers;

use App\Mail\Appointment\Updated as AppointmentUpdated;
use App\Mail\Appointment\Accepted as AppointmentAccepted;
use App\Mail\Appointment\Declined as AppointmentDeclined;
use App\Mail\Appointment\Received as AppointmentReceived;
use App\Models\Appointments\ClientProviderAppointment as Appointment;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ClientProviderAppointmentObserver
{
    /**
     * Handle the ClientProviderAppointment "created" event.
     *
     * @param  \App\Models\Appointments\ClientProviderAppointment  $clientProviderAppointment
     * @return void
     */
    public function created(Appointment $appointment)
    {
        // Notify provider about new appointment request
        if ($appointment->requested_by == "client") {
            $provider = $appointment->provider;
            $email = $provider->user->email;

            try {
                Mail::to($email)->send(new AppointmentReceived($appointment));
            } catch (Exception $error) {
                Log::critical('Could not send new appointment request notification to the provider!', [
                    'appointment' => $appointment->id,
                    'provider' => $provider->id,
                    'error' => $error->getMessage(),
                ]);
            }
        }

        // Notify client about new appointment fixation
        if ($appointment->requested_by == "provider") {
            $provider = $appointment->provider;
            $email = $provider->user->email;

            try {
                Mail::to($email)->send(new AppointmentReceived($appointment));
            } catch (Exception $error) {
                Log::critical('Could not send new appointment request notification to the provider!', [
                    'appointment' => $appointment->id,
                    'provider' => $provider->id,
                    'error' => $error->getMessage(),
                ]);
            }
        }
    }

    /**
     * Handle the ClientProviderAppointment "updated" event.
     *
     * @param  \App\Models\Appointments\ClientProviderAppointment  $clientProviderAppointment
     * @return void
     */
    public function updated(Appointment $appointment)
    {
        // Notify client about appointment declined
        if ($appointment->status == "declined") {
        }

        // Notify client that appointment is reviewed and waiting for payment
        if ($appointment->status == "reviewed") {
        }

        // Notify both that the appointment is ready
        if ($appointment->status == "pending") {
        }
    }

    /**
     * Handle the ClientProviderAppointment "deleted" event.
     *
     * @param  \App\Models\Appointments\ClientProviderAppointment  $clientProviderAppointment
     * @return void
     */
    public function deleted(Appointment $appointment)
    {
        //
    }

    /**
     * Handle the ClientProviderAppointment "restored" event.
     *
     * @param  \App\Models\Appointments\ClientProviderAppointment  $clientProviderAppointment
     * @return void
     */
    public function restored(Appointment $appointment)
    {
        //
    }

    /**
     * Handle the ClientProviderAppointment "force deleted" event.
     *
     * @param  \App\Models\Appointments\ClientProviderAppointment  $clientProviderAppointment
     * @return void
     */
    public function forceDeleted(Appointment $appointment)
    {
        //
    }
}
