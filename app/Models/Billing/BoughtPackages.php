<?php

namespace App\Models\Billing;

use App\Models\Packages;
use App\Models\Roles\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoughtPackages extends Model
{
    use HasFactory;

    // the table associated with this model
    protected $table = 'bought_packages';

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
     * Every bought_packages has a client record associated with it
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Every packages has a bought_packages record associated with it
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function packages()
    {
        return $this->belongsTo(Packages::class);
    }

    /**
     * Orders can has one transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }
}
