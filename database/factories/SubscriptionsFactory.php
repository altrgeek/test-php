<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Yaml\Yaml;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriptions>
 */
class SubscriptionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $options = Yaml::parseFile(resource_path('data/subscription.yaml'));
        $features = collect($options['features']['available']);
        $features = $features->map(fn (array $feature) => $feature['label']);

        return [
            'name' => $this->faker->words(5, true),
            'description' => $this->faker->sentence(),
            'price' => random_int(50, 10000),
            'duration' => random_int(10, 100) . '-' . $this->faker->randomElement(['Day']),
            'providers' => random_int(10, 100),
            'meta' => [
                'caps' => [
                    'available' => $this->faker->randomElements($features, random_int(0, 4))
                ]
            ]
        ];
    }
}
