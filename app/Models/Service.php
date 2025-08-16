<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'appointment_type_id',
        'sku',
        'price',
        'photo',
        'status'
    ];

    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id', 'id');
    }
}
