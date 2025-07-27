<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends BaseModel
{
    /** @use HasFactory<\Database\Factories\PrescriptionFactory> */
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_id',
        'notes',
    ];
}
