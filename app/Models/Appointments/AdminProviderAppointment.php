<?php

namespace App\Models\Appointments;

use App\Models\Roles\Admin;
use Illuminate\Support\Str;
use App\Models\Roles\Provider;
use App\Traits\HasAppointmentStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdminProviderAppointment extends Model
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
        'admin_id',
        'provider_id',
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
     * An appointment is created by/for an admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * An appointment is created by/for a provider
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
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
        static::creating(function (AdminProviderAppointment $appointment) {
            $appointment->uid = Str::orderedUuid();

            return $appointment;
        });
    }
}
