<?php

namespace App\Models\Appointments;

use Illuminate\Support\Str;
use App\Models\Roles\Client;
use App\Models\Billing\Order;
use App\Models\Roles\Provider;
use App\Traits\HasAppointmentStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientProviderAppointment extends Model
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
        'provider_id',
        'client_id',
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
     * The relationships that should always be loaded.
     *
     * @var array<string>
     */
    protected $with = [];
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
     * An appointment is created by/for a client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * An appointment has an order associated with it
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'appointment_id');
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
        static::creating(function (ClientProviderAppointment $appointment) {
            $appointment->uid = Str::orderedUuid();

            return $appointment;
        });
    }
}
