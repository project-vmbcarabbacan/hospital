<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInformation extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::observe(UserInformation::class);
    }

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'birthdate',
        'gender',
        'profile_photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
