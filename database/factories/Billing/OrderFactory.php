<?php

namespace Database\Factories\Billing;

use App\Models\Appointments\ClientProviderAppointment;
use App\Models\Roles\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $price = random_int(0, 100);

        return [
            'uid' => Str::orderedUuid(),
            'amount' => $price + $price ? ((random_int(0, 10) * 10) / 100) : 0,
            'status' => 'paid',
            'client_id' => Client::factory(),
            'appointment_id' => ClientProviderAppointment::factory()
        ];
    }
}
