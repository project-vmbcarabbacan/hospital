<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievement extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'year_awarded',
    ];
}
