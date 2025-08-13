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
        'license_number',
        'license_expiry',
        'birthdate',
        'hired_date',
        'gender',
        'bio',
        'is_visible',
        'days_of_working',
        'work_timing',
        'occupation_type',
        'profile_photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
