<?php

namespace App\Models\Appointments;

use App\Models\Roles\Admin;
use Illuminate\Support\Str;
use App\Models\Roles\SuperAdmin;
use App\Traits\HasAppointmentStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdminSuperAdminAppointment extends Model
{
    use HasFactory, HasAppointmentStatus, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'start',
        'ends_at',
        'duration',
        'status',
        'meeting_id',
        'meeting_platform',
        'super_admin_id',
        'admin_id',
        'requested_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start'    => 'datetime',
        'ends_at'  => 'datetime',
        'duration' => 'integer',
    ];

    /**
     * An appointment is created by/for a super-admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function superAdmin(): BelongsTo
    {
        return $this->belongsTo(SuperAdmin::class);
    }

    /**
     * An appointment is created by/for a admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * An appointment can have many appointment_meta
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointment_meta(): HasOne
    {
        return $this->hasOne(AppointmentMeta::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function (AdminSuperAdminAppointment $appointment) {
            $appointment->uid = Str::orderedUuid();

            return $appointment;
        });
    }
}
