<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedListing extends Model
{
    use HasFactory;
    //fillable
    protected $fillable = [
        'assignee_role',
        'accepted_id',
        'assignee_id',
        'created_at',
        'updated_at',
    ];
}
