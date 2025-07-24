<?php

namespace App\Application\DTOs;

use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\PasswordObj;

class LoginDto {
    public function __construct(
        public readonly EmailObj $email,
        public readonly PasswordObj $password
    ){}

    public static function fromArray(array $data): self {
        return new self(
            email: new EmailObj($data['email']),
            password: new PasswordObj($data['password']),
        );
    }
}
