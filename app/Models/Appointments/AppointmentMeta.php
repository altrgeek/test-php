<?php

namespace App\Models\Appointments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentMeta extends Model
{
    use HasFactory;

    /**
     * The table that is assigned to this model
     */
    protected $table = 'appointment_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'appointment_type',
        'appointment_id',
        'meta_key',
        'meta_value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta_value' => 'array',
    ];

    /**
     * An appointment_meta belongsTo one AdminSuperAdminAppointment appointment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adminSuperAdminAppointment()
    {
        return $this->belongsTo(AdminSuperAdminAppointment::class, 'appointment_id', 'id');
    }

        /**
     * An appointment_meta belongsTo one AdminSuperAdminAppointment appointment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adminProviderAppointment()
    {
        return $this->belongsTo(AdminProviderAppointment::class, 'appointment_id', 'id');
    }

        /**
     * An appointment_meta belongsTo one AdminSuperAdminAppointment appointment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clientProviderAppointment()
    {
        return $this->belongsTo(ClientProviderAppointment::class, 'appointment_id', 'id');
    }

}
