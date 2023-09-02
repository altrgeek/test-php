<?php

namespace App\Models;

use App\Models\Billing\BoughtPackages;
use App\Models\Roles\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    use HasFactory;

    // the table associated with this model
    protected $table = 'packages';

    // to make all fields fillable in table
    protected $guarded = [];

    /**
     * Every role has a user record associated with it
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Every role has a user record associated with it
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Every packages has many bought_packages record associated with it
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bought_packages()
    {
        return $this->hasMany(BoughtPackages::class);
    }
}
