<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'head_doctor_id',
        'photo',
        'working_hours',
    ];
}
