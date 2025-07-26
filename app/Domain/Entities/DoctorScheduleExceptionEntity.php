<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DateObj;
use App\Domain\ValueObjects\IdObj;

class DoctorScheduleExceptionEntity
{
    public function __construct(
        public readonly IdObj $user_id,
        public readonly DateObj $date,
        public readonly bool $is_available,
        public readonly string $notes
    ) {}
}
