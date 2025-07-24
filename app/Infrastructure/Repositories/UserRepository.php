<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use App\Domain\Interfaces\Repositories\UserRepositoryInterface;
use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\RoleIdObj;

class UserRepository implements UserRepositoryInterface
{

    public function findById(IdObj $id)
    {
        return User::find($id->value());
    }

    public function findByEmail(EmailObj $email)
    {
        return User::where('email', $email->value())->first();
    }

    public function findByPhone(string $phone)
    {
        return User::whereHas('information', function ($q) use($phone) {
                    $q->where('phone', $phone);
                })->first();
    }

    public function findByRole(RoleIdObj $role_id)
    {
        return User::where('role_id', $role_id->value())->get();
    }
}
