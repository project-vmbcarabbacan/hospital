<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends BaseModel
{
    /** @use HasFactory<\Database\Factories\PrescriptionItemFactory> */
    use HasFactory;
    protected $fillable = [
        'prescription_id',
        'medicine',
        'dosage',
        'instructions',
    ];
}
