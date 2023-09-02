<?php

namespace App\Concerns\Analytics;

use App\Models\Appointments\ClientProviderAppointment as CPAppointment;
use App\Models\Roles\Provider;
use App\Models\Therapies\VRTherapy;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

trait ParsesProvider
{
    /**
     * Get general statistics about the provided service provider which can be
     * shown in the analytics page.
     *
     * @param  \App\Models\Roles\Provider
     * @return stdClass
     */
    public static function getProviderStats(Provider $provider): stdClass
    {
        $provider->load(['user']);

        $id = $provider->id;
        $name = $provider->user->name;
        $clients = $provider->clients()->count();
        $earnings = DB::table('orders')
            ->join(
                sprintf('%s as appointments', app(CPAppointment::class)->getTable()),
                'orders.appointment_id',
                '=',
                'appointments.id'
            )
            ->where('appointments.provider_id', '=', $provider->id)
            ->sum('amount');
        $sessions = $provider->clientAppointments()->count();
        $therapies = $provider->vrTherapies()->count();
        $joined = $provider->user->created_at;

        return (object) compact(
            'id',
            'name',
            'clients',
            'earnings',
            'sessions',
            'therapies',
            'joined'
        );
    }

    public static function getProviderSessions(Provider $provider): Collection
    {
        $provider->load(['clientAppointments' => ['order', 'client' => ['user']]]);

        return $provider
            ->clientAppointments
            ->map(function (CPAppointment $appointment) {
                $id = $appointment->id;
                $duration = toHumanReadableTime($appointment->duration);
                $start = $appointment->start;
                $payment = $appointment?->order?->amount ?: 0;
                $platform = $appointment->meeting_platform;
                $client = $appointment->client->user->name;

                return (object) compact('id', 'duration', 'start', 'payment', 'platform', 'client');
            });
    }

    public static function getProviderTherapies(Provider $provider): Collection
    {
        $provider->load(['vrTherapies']);

        return $provider
            ->vrTherapies
            ->map(function (VRTherapy $therapy) {
                $id = $therapy->id;
                $name = $therapy->name;
                $options = $therapy->marketplaces()->count();
                $created_at = $therapy->created_at;

                return (object) compact('id', 'name', 'options', 'created_at');
            });
    }
}
