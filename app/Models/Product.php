<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'distributor_id',
        'brand_id',
        'sku',
        'name',
        'photo',
        'stocks',
        'price',
        'status'
    ];
}
