<?php

namespace App\Models\Doctor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /** @use HasFactory<\Database\Factories\Doctor\RatingFactory> */
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'rating',
        'comment',
        'is_approved',
    ];
}
