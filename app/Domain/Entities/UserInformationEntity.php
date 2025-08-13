<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DateObj;
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
        public readonly ?string $license_number = null,
        public readonly ?DateObj $license_expiry = null,
        public readonly ?DateObj $birthdate = null,
        public readonly ?DateObj $hired_date = null,
        public readonly ?string $gender = null,
        public readonly ?string $bio = null,
        public readonly ?bool $is_visible = true,
        public readonly ?string $days_of_working = null,
        public readonly ?string $work_timing = null,
        public readonly ?string $occupation_type = null,
        public readonly ?string $profile_photo = null,
    ) {}
}
