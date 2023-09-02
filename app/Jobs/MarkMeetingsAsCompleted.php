<?php

namespace App\Jobs;

use App\Models\Appointments\AdminProviderAppointment;
use App\Models\Appointments\AdminSuperAdminAppointment;
use App\Models\Appointments\ClientProviderAppointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MarkMeetingsAsCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        collect([
            AdminSuperAdminAppointment::class,
            AdminProviderAppointment::class,
            ClientProviderAppointment::class,
        ])
            ->map(function (string $class) {
                return $class::query()
                    ->where('status', 'pending')
                    ->where('ends_at', '<=', now());
            })
            ->each(fn ($query) => $query->update(['status' => 'completed']));
    }
}
