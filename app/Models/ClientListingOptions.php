<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientListingOptions extends Model
{
    use HasFactory;
    protected $table = 'client_group_listings_pivot';

    protected $fillable = [ 'group_listing_id','client_id'];

}
