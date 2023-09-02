<?php

namespace Database\Factories\Therapies;

use Illuminate\Database\Eloquent\Factories\Factory;

class MarketplaceOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->words(random_int(1, 3), true)),
            'url'  => $this->faker->url()
        ];
    }
}
