<?php

namespace App\Models\Roles;

use App\Models\User;
use App\Models\Billing\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Appointments\ClientProviderAppointment;
use App\Models\Billing\BoughtPackages;
use App\Traits\HandleUserRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, HandleUserRecord;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['provider_id'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<string>
     */
    protected $with = ['user'];

    /**
     * Every role has a user record associated with it
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Client is created by a `Provider`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * A client can have many `Appointment`s with a `Provider`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(ClientProviderAppointment::class, 'client_id');
    }

    /**
     * Get all requested appointments (create by client)
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function requestedAppointments(): Builder
    {
        return $this->appointments()->where('requested_by', 'client_id');
    }

    /**
     * Get all received appointment requests (create by provider)
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function receivedAppointments(): Builder
    {
        return $this->appointments()->where('requested_by', 'provider');
    }

    /**
     * A user can have many order linked to it (client only)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * A client can have many bought_packages linked to it (client only)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bought_packages(): HasMany
    {
        return $this->hasMany(BoughtPackages::class);
    }
}
