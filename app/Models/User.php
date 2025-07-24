<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Observers\UserObserver;
use App\Infrastructure\Readers\RoleFileReader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Domain\Interfaces\Services\RoleServiceInterface;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected static function booted()
    {
        static::observe(UserObserver::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function information()
    {
        return $this->hasOne(UserInformation::class, 'user_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(UserLog::class, 'user_id', 'id');
    }

    public function hasAnyPermission(array $required, RoleServiceInterface $roleService): bool
    {
        $permissions = $roleService->getPermissionsByRoleId($this->role_id);

        return !empty(array_intersect($permissions, $required));
    }
}
