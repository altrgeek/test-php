<?php

namespace Database\Factories\Roles;

use App\Models\User;
use App\Models\Roles\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'segment' => $this->faker->randomElement(array_keys(config('cogni.admins.segments')))
        ];
    }
}
