<?php

namespace Database\Factories\Chat;

use App\Enums\Chat\Chat as ChatType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat\Chat>
 */
class ChatFactory extends Factory
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
            'type' => ChatType::INDIVIDUAL(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function group()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ChatType::GROUP(),
                'name' => fake()->words(random_int(1, 3), true),
                'description' => random_int(0, 1) === 1 ? fake()->sentences(2, true) : null,
            ];
        });
    }
}
