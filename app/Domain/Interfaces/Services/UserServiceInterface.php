<?php

namespace App\Domain\Interfaces\Services;

use App\Domain\ValueObjects\IdObj;

interface UserServiceInterface
{
    public function currentUser();
    public function getUserProfileByUserId(IdObj $id);
}
