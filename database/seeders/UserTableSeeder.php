<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Roles\Admin;
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use App\Models\Roles\SuperAdmin;
use App\Models\Subscriptions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private const ADMINS_COUNT = 2;
    private const PROVIDERS_COUNT = 2;
    private const CLIENTS_COUNT = 2;

    public function run()
    {
        // Creating super admins
        $super_admin = User::factory()
            ->state([
                'email' => config('production.credentials.super_admin.email'),
                'password' => Hash::make(config('production.credentials.super_admin.password')),
            ])
            ->create()
            ->assignRole('super_admin');

        // Also create a record for super admin
        SuperAdmin::factory()->for($super_admin)->create();

        // Seed other roles only if app is not in production!
        if (App::environment('local', 'staging', 'testing'))
            Admin::factory()
                ->count(self::ADMINS_COUNT)
                ->create()
                ->each(function (Admin $admin) {
                    // Assign appropriate role to admin's user-record
                    $admin->user->assignRole('admin');

                    $subscription = Subscriptions::inRandomOrder()->first();

                    $admin->subscription()->create([
                        'subscriptions_id' => $subscription->id,
                        'name' => $subscription->name,
                        'price' => $subscription->price,
                    ]);

                    // Create specified number of providers
                    Provider::factory()
                        ->count(self::PROVIDERS_COUNT)
                        ->for($admin) // The providers will be created under current admin
                        ->create()
                        ->each(function (Provider $provider) {
                            // Assign appropriate role to provider's user-record
                            $provider->user->assignRole('provider');

                            // Create specified number of clients
                            Client::factory()
                                ->count(self::CLIENTS_COUNT)
                                ->for($provider) // The clients will be created under current provider
                                ->create()
                                ->each(function (Client $client) {
                                    // Assign appropriate role to client's user-record
                                    $client->user->assignRole('client');
                                });
                        });
                });
    }
}
