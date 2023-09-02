<?php

namespace Tests\Feature\Users;

use App\Models\Roles\Admin;
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Roles\SuperAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuperAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a super admin can create a new administrator.
     *
     * @return void
     */
    public function test_super_admin_can_create_admins(): void
    {
        // Pick a random super admin
        $user = SuperAdmin::inRandomOrder()->first()->user;

        // Generate some fake data for the new admin record
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'segment' => $this->faker->randomElement(array_keys(config('cogni.admins.segments'))),
            'password' => Str::random(random_int(6, 20)),
        ];

        // Login as selected super admin and create a new admin
        $response = $this
            ->actingAs($user, 'web')
            ->post(route('super_admin.dashboard.admins'), $data);

        // Super admin will be redirected to admins management dashboard upon
        // success
        $response->assertRedirect(route('super_admin.dashboard.admins'));

        // Make sure a new user is created against provided email address
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name'  => $data['name'],
        ]);

        // Get the newly created admin's user record
        $admin = User::with(['admin'])->where('email', $data['email'])->first();

        // Make sure provided segment reflects in created admin's record
        $this->assertEquals($data['segment'], $admin->admin->segment);
    }

    /**
     * Test that super admin can create purchasable subscriptions.
     *
     * @return void
     */
    public function test_super_admin_can_create_subscriptions(): void
    {
        // Pick a random super admin
        $user = SuperAdmin::inRandomOrder()->first()->user;

        // Generate some fake data for the new subscription record
        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentences(3, true),
            'price' => random_int(50, 10000),
            'number' => random_int(1, 60),
            'duration' => $this->faker->randomElement(['Days', 'Months', 'Years']),
            'providers' => random_int(10, 100),
        ];

        // Login as selected super admin and create a new subscription
        $response = $this
            ->actingAs($user, 'web')
            ->post(route('super_admin.dashboard.subscriptions.create'), $data);

        // Super admin will be redirected to subscriptions management dashboard
        // upon success
        $response->assertRedirect(route('super_admin.dashboard.subscriptions'));

        // Make sure a new subscription is created with appropriate data
        $this->assertDatabaseHas('subscriptions', [
            'name'  => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'duration' => sprintf('%d-%s', $data['number'], $data['duration']),
            'providers' => $data['providers'],
        ]);
    }

    public function test_super_admin_can_delete_admin_and_all_sub_roles(): void
    {
        // Select a randomly picked super admin
        $super_admin = SuperAdmin::first();

        // First admin with all of it's providers and clients
        $admin = Admin::with(['providers', 'providers.clients'])->first();

        $response = $this
            ->actingAs($super_admin->user)
            ->delete(route('super_admin.dashboard.admins.delete', $admin->id));

        // The super admin should be redirected to admin management dashboard
        // upon success
        $response->assertRedirect(route('super_admin.dashboard.admins'));

        $admin->providers->each(function (Provider $provider) {
            $this->assertDatabaseMissing('providers', ['id' => $provider->id]);

            // Providers's user record should also be deleted
            $this->assertDatabaseMissing('users', [
                'id'    => $provider->user->id,
                'email' => $provider->user->email,
            ]);

            $provider->clients->each(function (Client $client) {
                $this->assertDatabaseMissing('clients', ['id' => $client->id]);

                // Client's user record should also be deleted
                $this->assertDatabaseMissing('users', [
                    'id'    => $client->user->id,
                    'email' => $client->user->email,
                ]);
            });
        });
    }
}
