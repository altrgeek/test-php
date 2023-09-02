<?php

namespace Database\Seeders;

use App\Models\Appointments\AdminProviderAppointment;
use App\Models\Appointments\AdminSuperAdminAppointment;
use App\Models\Appointments\ClientProviderAppointment;
use App\Models\Billing\Order;
use App\Models\Billing\Transaction;
use App\Models\Roles\Admin;
use Illuminate\Support\Str;
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use App\Models\Roles\SuperAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::select(['id', 'provider_id', 'user_id'])
            ->with(['user', 'provider'])
            ->get()
            ->each(function (Client $client) {
                loop(function (Client $client) {
                    $order = Order::factory()
                        ->for(
                            ClientProviderAppointment::factory()
                                ->for($client)
                                ->for($client->provider)
                                ->create(),
                            'appointment'
                        )
                        ->for($client)
                        ->create();

                    if ($order->price)
                        Transaction::factory()
                            ->state(['amount' => $order->amount])
                            ->for($order)
                            ->for($client);
                }, [$client], 5);
            });

        Provider::select(['id', 'admin_id', 'user_id'])
            ->with(['user', 'admin'])
            ->get()
            ->each(function (Provider $provider) {
                loop(function () use ($provider) {
                    AdminProviderAppointment::factory()
                        ->for($provider)
                        ->for($provider->admin)
                        ->create();
                }, [], 3);
            });

        $admins = Admin::select(['id']);
        SuperAdmin::select(['id', 'user_id'])
            ->get()
            ->each(function (SuperAdmin $super_admin) use ($admins) {
                $admins->each(function (Admin $admin) use ($super_admin) {
                    loop(function (SuperAdmin $super_admin, Admin $admin) {
                        AdminSuperAdminAppointment::factory()
                            ->for($super_admin)
                            ->for($admin)
                            ->create();
                    }, [$super_admin, $admin], 2);
                });
            });
    }
}
