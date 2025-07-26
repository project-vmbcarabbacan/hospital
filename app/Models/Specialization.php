<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialization extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'description',
        'photo',
    ];
}
