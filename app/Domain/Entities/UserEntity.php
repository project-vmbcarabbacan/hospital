<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\PasswordObj;

class UserEntity {

    public function __construct(
        public readonly string $name,
        public readonly EmailObj $email,
        public readonly int $role_id,
        public readonly string $status,
        public readonly ?int $id = null,
        public readonly ?int $specialization_id = null,
        public readonly ?string $email_verified_at = null,
        public readonly ?PasswordObj $password = null,
    ){}
}
