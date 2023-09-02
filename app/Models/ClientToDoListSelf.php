<?php

namespace App\Models;

use App\Models\Therapies\VRTherapy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientToDoListSelf extends Model
{
    use HasFactory;
    protected $table = 'client_to_do_list_self';

    protected $fillable = [
        'title','description','start','duration','end','assignee_id','assigned_to_id','vr_therapy_id','unit',"status",'assignee_role'
    ];

 /**
     * Every client_to_do_list_self record associated with it
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vrTherapy()
    {
        return $this->belongsTo(VRTherapy::class);
    }
}
