<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DateObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\TimeOfDayObj;

class AppointmentEntity
{

    public function __construct(
        public readonly IdObj $doctor_id,
        public readonly IdObj $patient_id,
        public readonly DateObj $date,
        public readonly TimeOfDayObj $appointment_time,
        public readonly string $status,
        public readonly string $notes,
    ) {}
}
