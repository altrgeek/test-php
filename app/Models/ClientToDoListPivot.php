<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientToDoListPivot extends Model
{
    use HasFactory;
    protected $table = 'client_to_do_list_pivot';

    protected $fillable = [
        'client_id','to_do_list_id'
    ];

    /**
     * Every client_to_do_list_pivot record associated with it
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
}
