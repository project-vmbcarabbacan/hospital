<?php

namespace App\Models\Doctor;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class ScheduleInstance extends BaseModel
{
    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time',
        'location',
        'source_schedule_id',
        'status',
        'google_event_id',
    ];
}
