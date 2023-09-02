<?php

namespace App\Models;

use App\Concerns\Subscriptions\HasSubscription;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Billing\{Transaction, Subscription, BoughtPackages};
use App\Traits\HasRoles;
use App\Traits\Chat\HasChats;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasChats, HasSubscription;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'address',
        'longitude',
        'latitude',
        'dob',
        'phone',
        'gender',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'datetime'
    ];

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.' . $this->id;
    }

    public function meta(): HasMany
    {
        return $this->hasMany(UserMeta::class);
    }

    /**
     * A super_admin can create many subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscriptions::class);
    }

    /**
     * A super_admin can create many subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscription(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * A user can have many transactions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * A user can have many packages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Packages::class);
    }

    /**
     * A user can have purchase/buy many packages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bought_packages(): HasMany
    {
        return $this->hasMany(BoughtPackages::class);
    }

    /**
     * Returns formatted date of birth of the user.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function dobDate(): Attribute
    {
        return Attribute::make(function (mixed $value, array $attributes) {
            if (!$attributes['dob']) return null;

            $dob = new Carbon($attributes['dob']);

            return $dob->format('Y-m-d');
        });
    }
}
