<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status'
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'appointment_type_id', 'id');
    }
}
