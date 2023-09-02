<?php

namespace Database\Factories\Billing;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uid' => Str::orderedUuid(),
            'amount' => random_int(0, 100) + ((random_int(0, 10) * 10) / 100),
            'user_id' => User::factory(),
            'subscriptions_id' => null,
            'order_id' => null,
            'bought_packages_id' => null
        ];
    }
}
