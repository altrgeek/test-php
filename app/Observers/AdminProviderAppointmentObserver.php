<?php

namespace App\Observers;

use App\Models\Appointments\AdminProviderAppointment;

class AdminProviderAppointmentObserver
{
    /**
     * Handle the AdminProviderAppointment "created" event.
     *
     * @param  \App\Models\Appointments\AdminProviderAppointment  $adminProviderAppointment
     * @return void
     */
    public function created(AdminProviderAppointment $adminProviderAppointment)
    {
        //
    }

    /**
     * Handle the AdminProviderAppointment "updated" event.
     *
     * @param  \App\Models\Appointments\AdminProviderAppointment  $adminProviderAppointment
     * @return void
     */
    public function updated(AdminProviderAppointment $adminProviderAppointment)
    {
        //
    }

    /**
     * Handle the AdminProviderAppointment "deleted" event.
     *
     * @param  \App\Models\Appointments\AdminProviderAppointment  $adminProviderAppointment
     * @return void
     */
    public function deleted(AdminProviderAppointment $adminProviderAppointment)
    {
        //
    }

    /**
     * Handle the AdminProviderAppointment "restored" event.
     *
     * @param  \App\Models\Appointments\AdminProviderAppointment  $adminProviderAppointment
     * @return void
     */
    public function restored(AdminProviderAppointment $adminProviderAppointment)
    {
        //
    }

    /**
     * Handle the AdminProviderAppointment "force deleted" event.
     *
     * @param  \App\Models\Appointments\AdminProviderAppointment  $adminProviderAppointment
     * @return void
     */
    public function forceDeleted(AdminProviderAppointment $adminProviderAppointment)
    {
        //
    }
}
