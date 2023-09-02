<?php

namespace Database\Factories\Roles;

use App\Models\User;
use App\Models\Roles\Admin;
use App\Models\Roles\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'admin_id' => Admin::factory()
        ];
    }
}
