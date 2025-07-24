<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\RoleIdObj;

interface UserRepositoryInterface
{
    public function findById(IdObj $id);
    public function findByEmail(EmailObj $email);
    public function findByPhone(string $phone);
    public function findByRole(RoleIdObj $role_id);
}
