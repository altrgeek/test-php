<?php

namespace App\Models\Roles;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Appointments\AdminProviderAppointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Appointments\ClientProviderAppointment;
use App\Models\Therapies\ArVr;
use App\Models\Therapies\VRTherapy;
use App\Traits\HandleUserRecord;

class Provider extends Model
{
    use HasFactory, HandleUserRecord;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['admin_id'];

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
     * A provider is created by an `Admin`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * A provider can create many `Client`s
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    /**
     * ========================================
     * APPOINTMENTS
     * ========================================
     */

    /**
     * A provider can have many `Appointment` with admins
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adminAppointments(): HasMany
    {
        return $this->hasMany(AdminProviderAppointment::class, 'provider_id');
    }

    /**
     * A provider can have many `Appointment` with clients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientAppointments(): HasMany
    {
        return $this->hasMany(ClientProviderAppointment::class, 'provider_id');
    }

    /**
     * A provider can have many VR Therapies
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vrTherapies(): HasMany
    {
        return $this->hasMany(VRTherapy::class);
    }
}
