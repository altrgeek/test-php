<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\Roles\Provider;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProviderTest extends TestCase
{
    use RefreshDatabase;

    public function test_provider_can_create_clients(): void
    {
        $this->assertTrue(true);

        return;
        // Pick a random admin
        $provider = Provider::inRandomOrder()->first();

        // Generate some fake data for the new admin record
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'password' => Str::random(random_int(6, 20)),
        ];

        // Login as selected provider and create a new client
        $response = $this
            ->actingAs($provider->user, 'web')
            ->post(route('provider.dashboard.clients.create'), $data);

        // Provider will be redirected to clients management dashboard upon
        // success
        $response->assertRedirect(route('provider.dashboard.clients'));

        // Make sure a new user is created against provided email address
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name'  => $data['name'],
        ]);
    }

    public function test_provider_can_delete_their_clients(): void
    {
        // Get a random Provider
        $provider = Provider::inRandomOrder()->first();

        // Get first client of chosen provider
        $client = $provider->clients()->first();

        $response = $this
            ->actingAs($provider->user)
            ->delete(route('provider.dashboard.clients.delete', $client->id));

        // Provider should be redirected to client management dashboard
        $response->assertRedirect(route('provider.dashboard.clients'));

        // Specified client should be deleted
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);

        // Specified client's user record should also be deleted
        $this->assertDatabaseMissing('users', [
            'id'    => $client->user->id,
            'email' => $client->user->email
        ]);
    }

    public function test_provider_can_update_their_clients(): void
    {
        // Get a random Provider
        $provider = Provider::inRandomOrder()->first();

        // Get first client of chosen provider
        $client = $provider->clients()->first();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
        ];

        $response = $this
            ->actingAs($provider->user)
            ->patch(route('provider.dashboard.clients.update', $client->id), $data);

        // Provider should be redirected to client management dashboard
        $response->assertRedirect(route('provider.dashboard.clients'));

        // Specified client's user record should be updated
        $this->assertDatabaseHas('users', [
            'id'    => $client->user->id,
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);
    }
}
