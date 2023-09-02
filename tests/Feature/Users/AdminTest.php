<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use App\Models\Roles\Admin;
use App\Models\Roles\Client;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a super admin can create a new administrator.
     *
     * @return void
     */
    public function test_admin_can_create_providers(): void
    {
        // Pick a random admin
        $admin = Admin::inRandomOrder()->first();

        // Generate some fake data for the new admin record
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'password' => Str::random(random_int(6, 20)),
        ];

        // Login as selected admin and create a new admin
        $response = $this
            ->actingAs($admin->user, 'web')
            ->post(route('admin.dashboard.providers.create'), $data);

        // Admin will be redirected to providers management dashboard upon
        // success
        $response->assertRedirect(route('admin.dashboard.providers'));

        // Make sure a new user is created against provided email address
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name'  => $data['name'],
        ]);

        // Get the newly created provider
        $provider = User::with(['provider'])
            ->where('email', $data['email'])
            ->first();

        // Make sure provided segment reflects in created admin's record
        $this->assertEquals($admin->id, $provider->provider->admin_id);
    }

    public function test_admin_cannot_create_providers_without_a_subscription(): void
    {
        // Pick a random admin
        $admin = Admin::inRandomOrder()->first();

        // Remove admin's subscription
        $admin->subscription()->delete();

        // Generate some fake data for the new admin record
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'password' => Str::random(random_int(6, 20)),
        ];

        // Login as selected admin and create a new admin
        $response = $this
            ->actingAs($admin->user, 'web')
            ->post(route('admin.dashboard.providers.create'), $data);

        // Admin will be redirect to dashboard
        $response->assertRedirect(route('admin.dashboard'));

        // Database should not have the user with the email that we generated
        $this->assertDatabaseMissing('users', [
            'email' => $data['email']
        ]);
    }

    public function test_admin_can_delete_providers(): void
    {
        // Select a randomly picked admin
        $admin = Admin::inRandomOrder()->first();

        // Get first provider created by the admin
        $provider = $admin->providers()->first();

        $response = $this
            ->actingAs($admin->user)
            ->delete(route('admin.dashboard.providers.delete', $provider->id));

        // The admin should be redirected to provider management dashboard upon
        // success
        $response->assertRedirect(route('admin.dashboard.providers'));

        // Provider's record should be deleted form database
        $this->assertDatabaseMissing('providers', [
            'id'       => $provider->id,
            'admin_id' => $admin->id
        ]);

        // Provider's user record should also be deleted behind the scenes
        // using eloquent events
        $this->assertDatabaseMissing('users', [
            'id'    => $provider->user->id,
            'email' => $provider->user->email,
        ]);
    }

    public function test_admin_can_delete_provider_and_all_of_their_clients(): void
    {
        // Select a randomly picked admin
        $admin = Admin::inRandomOrder()->first();

        // Get first provider with all of it's clients
        $provider = $admin->providers()->with(['clients'])->first();

        $response = $this
            ->actingAs($admin->user)
            ->delete(route('admin.dashboard.providers.delete', $provider->id));

        // The admin should be redirected to provider management dashboard upon
        // success
        $response->assertRedirect(route('admin.dashboard.providers'));

        $provider->clients->each(function (Client $client) {
            $this->assertDatabaseMissing('clients', [
                'id' => $client->id,
            ]);

            // Client's user record should also be deleted
            $this->assertDatabaseMissing('users', [
                'id' => $client->user->id,
                'email' => $client->user->email,
            ]);
        });
    }
}
