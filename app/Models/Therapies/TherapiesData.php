<?php

namespace App\Models\Therapies;

use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TherapiesData extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['provider_id', 'client_id','data_file'];
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

}
