<?php

namespace App\Concerns\Analytics;

use App\Models\Appointments\ClientProviderAppointment as CPAppointment;
use App\Models\Billing\BoughtPackages;
use App\Models\Billing\Order;
use App\Models\Billing\Transaction;
use App\Models\Roles\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

trait ParsesClient
{
    /**
     * Get general statistics about the provided client which can be shown in
     * the analytics page.
     *
     * @param  \App\Models\Roles\Client
     * @return stdClass
     */
    public static function getClientStats(Client $client): stdClass
    {
        $client->load(['user']);

        $id = $client->id;
        $name = $client->user->name;
        $sessions = $client->appointments()->count();
        $spending = DB::table(
            DB::raw(
                str_replace(
                    ':client_id',
                    $client->id,
                    '(
                        SELECT SUM(p.price) as price
                        FROM packages p
                            INNER JOIN bought_packages bp ON p.id = bp.packages_id
                        WHERE bp.client_id = :client_id
                        UNION ALL
                        SELECT SUM(o.amount) as price
                        FROM orders o
                            INNER JOIN client_provider_appointments cpa ON o.appointment_id = cpa.id
                        WHERE cpa.client_id = :client_id
                    ) t',
                )
            )
        )
            ->sum('price');
        $packages = $client->bought_packages()->count();
        $joined = $client->user->created_at;

        return (object) compact('id', 'name', 'sessions', 'spending', 'packages', 'joined');
    }

    /**
     * Get details about all of client's sessions.
     *
     * @param  \App\Models\Roles\Client
     * @return \Illuminate\Support\Collection<stdClass>
     */
    public static function getClientSessions(Client $client): Collection
    {
        $client->load(['appointments' => ['order']]);

        return
            $client
            ->appointments
            ->map(function (CPAppointment $appointment) {
                $id = $appointment->id;
                $duration = toHumanReadableTime($appointment->start->diffInSeconds($appointment->end));
                $platform = $appointment->meeting_platform;
                $start = $appointment->start;
                $payment = optional($appointment->order, fn (Order $order) => $order->amount);
                $status = $appointment->status;

                return (object) compact('id', 'duration', 'platform', 'start', 'payment', 'status');
            });
    }

    /**
     * Get details about client's spending.
     *
     * @param  \App\Models\Roles\Client
     * @return \Illuminate\Support\Collection<stdClass>
     */
    public static function getClientSpending(Client $client): Collection
    {
        $client->load(['user' => ['transactions']]);

        return $client
            ->user
            ->transactions
            ->map(function (Transaction $transaction) {
                $id = $transaction->transaction_id;
                $product = $transaction->order_id ? 'appointment fee' : 'package payment';
                $amount = $transaction->amount;
                $purchased_on = $transaction->created_at->format('d-m-Y \a\t h:i:s A');

                return (object) compact('id', 'product', 'amount', 'purchased_on');
            });
    }

    /**
     * Get details about client's bought packages.
     *
     * @param  \App\Models\Roles\Client
     * @return \Illuminate\Support\Collection<stdClass>
     */
    public static function getClientPackages(Client $client): Collection
    {
        $client->load(['bought_packages' => ['packages']]);

        return $client
            ->bought_packages
            ->map(function (BoughtPackages $subscription) {
                $id = $subscription->packages->id;
                $name = $subscription->packages->title;
                $remaining_sessions = $subscription->sessions;
                $total_sessions = $subscription->packages->sessions;
                $price = $subscription->amount;
                $purchased_on = $subscription->created_at->format('d-m-Y \a\t h:i A');

                return (object) compact(
                    'id',
                    'name',
                    'price',
                    'remaining_sessions',
                    'total_sessions',
                    'purchased_on'
                );
            });
    }
}
