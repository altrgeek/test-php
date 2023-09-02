<?php

namespace Database\Factories\Appointments;

use App\Concerns\Testing\FakesAppointments;
use App\Models\Roles\Admin;
use App\Models\Roles\SuperAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointments\AdminSuperAdminAppointment>
 */
class AdminSuperAdminAppointmentFactory extends Factory
{
    use FakesAppointments;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return array_merge(static::getDefinitions(), [
            'super_admin_id' => SuperAdmin::factory(),
            'admin_id' => Admin::factory(),
        ]);
    }
}
