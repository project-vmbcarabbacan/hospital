<?php

namespace App\Domain\Interfaces\Repositories;

use App\Application\DTOs\CreateUserDto;
use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\PasswordObj;

interface AuthRepositoryInterface
{
    public function login(EmailObj $email, PasswordObj $password);
    public function createUser(CreateUserDto $data);
    public function updatePassword(IdObj $id, PasswordObj $password);
    public function sendForgotPasswordCode(EmailObj $email);
}
