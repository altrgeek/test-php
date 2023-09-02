<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Collection of created role models
        collect(config('cogni.roles.available'))->map(function (string $name) {
            Role::create(compact('name'));
        });
    }
}
