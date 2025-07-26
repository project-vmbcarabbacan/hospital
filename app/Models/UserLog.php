<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class UserLog extends BaseModel
{
    protected $fillable = [
        'user_id',
        'type',
        'description',
    ];
}
