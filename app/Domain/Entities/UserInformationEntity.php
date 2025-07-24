<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class UserInformationEntity
{

    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $phone,
        public readonly ?IdObj $user_id = null,
        public readonly ?string $title = null,
        public readonly ?string $address = null,
        public readonly ?string $birthdate = null,
        public readonly ?string $gender = null,
        public readonly ?string $bio = null,
        public readonly ?int $experience_years = null,
        public readonly ?bool $is_visible = true,
        public readonly ?string $profile_photo = null,
    ) {}
}
