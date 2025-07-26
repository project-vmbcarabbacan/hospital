<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sku',
        'price',
        'photo',
        'status'
    ];
}
