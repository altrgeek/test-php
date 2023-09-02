<?php

namespace App\Models\Roles;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Appointments\AdminProviderAppointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Appointments\AdminSuperAdminAppointment;
use App\Models\Billing\Subscription;
use App\Models\Packages;
use App\Traits\HandleUserRecord;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Admin extends Model
{
    use HasFactory, HandleUserRecord;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'segment',
        'primary_color',
        'secondary_color',
        'text_color',
        'logo',
        'website'
    ];

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
     * ========================================
     * RELATIONSHIPS WITH OTHER ROLES
     * ========================================
     */

    /**
     * `Admin` can create many `Providers`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }

    /**
     * Admin `has many` clients `through` a provider
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function clients(): HasManyThrough
    {
        return $this->hasManyThrough(
            Client::class, // Has many clients
            Provider::class, // Through providers
            'admin_id', // Foreign key on `clients` table
            'provider_id', // Foreign key on `providers` table
            'id', // Local key on the `admins` table
            'id', // Local key on the `providers` table
        );
    }

    /**
     * ========================================
     * APPOINTMENTS WITH SUPER ADMINS
     * ========================================
     */

    /**
     * An admin can have many `Appointment` with super-admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function superAdminAppointments(): HasMany
    {
        return $this->hasMany(AdminSuperAdminAppointment::class, 'admin_id');
    }

    /**
     * Get all requested appointments with super-admin (create by admin)
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function requestedSuperAdminAppointments(): Builder
    {
        return $this->superAdminAppointments()->where('requested_by', 'admin');
    }

    /**
     * Get all received appointments with super-admin (create by super-admin)
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function receivedSuperAdminAppointments(): Builder
    {
        return $this->superAdminAppointments()->where('requested_by', 'super_admin');
    }


    /**
     * ========================================
     * APPOINTMENTS WITH PROVIDERS
     * ========================================
     */

    /**
     * An admin can have many `Appointment` with providers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function providerAppointments(): HasMany
    {
        return $this->hasMany(AdminProviderAppointment::class, 'admin_id');
    }

    /**
     * Get all requested appointments with provider (create by admin)
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function requestedProviderAppointments(): Builder
    {
        return $this->providerAppointments()->where('requested_by', 'admin');
    }

    /**
     * Get all received appointments with providers (create by provider)
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function receivedProviderAppointments(): Builder
    {
        return $this->providerAppointments()->where('requested_by', 'provider');
    }

    /**
     * An admin can have one `Subscription` active at a time
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'admin_id');
    }

    /**
     * An admin can create many `Packages`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Packages::class);
    }
}
