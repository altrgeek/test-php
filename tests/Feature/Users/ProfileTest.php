<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a registered user can update his own profile.
     *
     * @return void
     */
    public function test_can_update_own_profile(): void
    {
        // Grab a random user from the database
        $user = User::inRandomOrder()->first();

        // Generate some new fake data for update
        $data = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->e164PhoneNumber(),
            'dob' => $this->faker->date(),
            'address' => $this->faker->address(),
        ];

        // Authenticate as the current user and update profile with generated
        // random data
        $response = $this
            ->actingAs($user, 'web')
            ->put(route('dashboard.profile.update'), $data);

        // Should redirect to dashboard upon success
        $response->assertRedirect(route('dashboard.profile'));

        $user = $user->refresh(); // Get updated records from database

        // Ensure records in database are updated with the provided ones
        $this->assertSame($user->name, $data['name']);
        $this->assertSame($user->phone, $data['phone']);
        $this->assertSame($user->dob->format('Y-m-d'), $data['dob']);
        $this->assertSame($user->address, $data['address']);
    }
}
