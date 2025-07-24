<?php

namespace App\Domain\Interfaces\Services;

use App\Application\DTOs\LoginDto;

interface AuthServiceInterface
{
    public function login(LoginDto $dto);
}
