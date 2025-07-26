<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Distributor extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'contact',
        'phone',
        'address',
        'photo',
    ];
}
