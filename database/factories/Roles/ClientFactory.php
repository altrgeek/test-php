<?php

namespace Database\Factories\Roles;

use App\Models\User;
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'provider_id' => Provider::factory()
        ];
    }
}
