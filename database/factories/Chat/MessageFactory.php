<?php

namespace Database\Factories\Chat;

use App\Enums\Chat\Message\Status;
use App\Enums\Chat\Message\Type;
use App\Models\Chat\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content' => fake()->sentences(random_int(1, 4), true),
            'type'    => Type::TEXT,
            'status'  => fake()->randomElement(Status::values()),
            'chat_id' => Chat::factory(),
            'user_id' => User::factory(),
        ];
    }
}
