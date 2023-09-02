<?php

namespace Database\Factories\Therapies;

use Illuminate\Database\Eloquent\Factories\Factory;

class VRTherapyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'        => ucfirst($this->faker->words(random_int(2, 4), true)),
            'description' => ucfirst($this->faker->sentences(random_int(1, 3), true)),
            'duration'      => ucfirst($this->faker->time()),
        ];
    }
}
