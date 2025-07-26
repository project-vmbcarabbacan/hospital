<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorSpecialization extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'specialization_id',
    ];
}
