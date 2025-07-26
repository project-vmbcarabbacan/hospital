<?php

namespace App\Models\Doctor;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'day_of_week',
        'start_time',
        'end_time',
        'location',
        'is_active',
    ];
}
