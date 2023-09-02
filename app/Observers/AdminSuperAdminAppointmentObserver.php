<?php

namespace App\Observers;

use App\Models\Appointments\AdminSuperAdminAppointment;

class AdminSuperAdminAppointmentObserver
{
    /**
     * Handle the AdminSuperAdminAppointment "created" event.
     *
     * @param  \App\Models\Appointments\AdminSuperAdminAppointment  $adminSuperAdminAppointment
     * @return void
     */
    public function created(AdminSuperAdminAppointment $adminSuperAdminAppointment)
    {
        //
    }

    /**
     * Handle the AdminSuperAdminAppointment "updated" event.
     *
     * @param  \App\Models\Appointments\AdminSuperAdminAppointment  $adminSuperAdminAppointment
     * @return void
     */
    public function updated(AdminSuperAdminAppointment $adminSuperAdminAppointment)
    {
        //
    }

    /**
     * Handle the AdminSuperAdminAppointment "deleted" event.
     *
     * @param  \App\Models\Appointments\AdminSuperAdminAppointment  $adminSuperAdminAppointment
     * @return void
     */
    public function deleted(AdminSuperAdminAppointment $adminSuperAdminAppointment)
    {
        //
    }

    /**
     * Handle the AdminSuperAdminAppointment "restored" event.
     *
     * @param  \App\Models\Appointments\AdminSuperAdminAppointment  $adminSuperAdminAppointment
     * @return void
     */
    public function restored(AdminSuperAdminAppointment $adminSuperAdminAppointment)
    {
        //
    }

    /**
     * Handle the AdminSuperAdminAppointment "force deleted" event.
     *
     * @param  \App\Models\Appointments\AdminSuperAdminAppointment  $adminSuperAdminAppointment
     * @return void
     */
    public function forceDeleted(AdminSuperAdminAppointment $adminSuperAdminAppointment)
    {
        //
    }
}
