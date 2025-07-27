<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DateObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\TimeOfDayObj;

class AppointmentFilterEntity
{

    public function __construct(
        public readonly IdObj $doctor_id,
        public readonly ?DateObj $start_date = null,
        public readonly ?DateObj $end_date = null,
        public readonly ?TimeOfDayObj $appointment_time = null,
        public readonly ?string $status = null,
    ) {}
}
