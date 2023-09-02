<?php

namespace App\Models\Roles;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Appointments\AdminSuperAdminAppointment;
use App\Traits\HandleUserRecord;

class SuperAdmin extends Model
{
    use HasFactory, HandleUserRecord;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['user_id'];

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
     * A super-admin can have many `Appointment`s
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(AdminSuperAdminAppointment::class, 'super_admin_id');
    }

    /**
     * Get all requested appointments (create by super-admin)
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function requestedAppointments(): Builder
    {
        return $this->appointments()->where('requested_by', 'super_admin');
    }

    /**
     * Get all received appointment requests (create by admins)
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function receivedAppointments(): Builder
    {
        return $this->appointments()->where('requested_by', 'admin');
    }
}
