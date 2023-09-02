<?php

namespace App\Http\Controllers\Roles\SuperAdmin;

use Illuminate\View\View;
use App\Models\Roles\Admin;
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use App\Http\Controllers\Controller;
use App\Models\Appointments\AdminProviderAppointment;
use App\Models\Appointments\AdminSuperAdminAppointment;
use App\Models\Appointments\ClientProviderAppointment;

class SuperAdminController extends Controller
{
    /**
     * Load the super admin dashboard with birds-eye view of all registered
     * users on Cogni platform
     *
     * @return \Illuminate\View\View
     */
    public function dashboard(): View
    {
        // Grab only number of rows from database
        $clients = Client::count();
        $admins = Admin::count();
        $providers = Provider::count();
        // Sum all the models to get total user (except super admins)
        $users = $admins + $providers + $clients;


        return view(
            'roles.super-admin.dashboard',
            [
                ...compact('users', 'providers', 'admins', 'clients'),
                'appointments' => self::getAppointmentCounts(),
            ]
        );
    }

    private static function getAppointmentCounts()
    {
        $entities = collect([
            AdminSuperAdminAppointment::class,
            AdminProviderAppointment::class,
            ClientProviderAppointment::class,
        ]);

        return [
            'total' => $entities
                ->map(fn (string $entity) => $entity::count())
                ->reduce(fn ($carry, $item) => $carry + $item, 0),
            'completed' => $entities
                ->map(fn (string $entity) => $entity::where('status', 'completed')->count())
                ->reduce(fn ($carry, $item) => $carry + $item, 0),
        ];
    }
}
