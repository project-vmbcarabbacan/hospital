<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\DayOfWeekObj;
use App\Domain\ValueObjects\TimeOfDayObj;

class DoctorScheduleEntity
{
    public function __construct(
        public readonly IdObj $user_id,
        public readonly DayOfWeekObj $day_of_week,
        public readonly TimeOfDayObj $start_time,
        public readonly TimeOfDayObj $end_time,
        public readonly string $location,
        public readonly bool $is_active
    ) {}
}
