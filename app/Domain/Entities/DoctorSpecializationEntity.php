<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class  DoctorSpecializationEntity
{
    public function __construct(
        public readonly ?IdObj $user_id = null,
        public readonly ?IdObj $specialization_id = null,
    ) {}
}
