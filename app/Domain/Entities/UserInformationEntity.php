<?php

namespace App\Domain\Entities;

class UserInformationEntity {

    public function __construct(
        public readonly string $phone,
        public readonly ?int $user_id = null,
        public readonly ?string $address = null,
        public readonly ?string $birthdate = null,
        public readonly ?string $gender = null,
        public readonly ?string $profile_photo = null,
    ){}
}
