<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Observers\UserInformationObserver;

class UserInformation extends BaseModel
{
    use HasFactory;
    protected static function booted()
    {
        static::observe(UserInformationObserver::class);
    }

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'title',
        'phone',
        'address',
        'birthdate',
        'gender',
        'bio',
        'experience_years',
        'is_visible',
        'profile_photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
