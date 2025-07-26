<?php

namespace App\Models\Doctor;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleException extends BaseModel
{
    /** @use HasFactory<\Database\Factories\Doctor\ScheduleExceptionFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date',
        'is_available',
        'notes',
    ];
}
