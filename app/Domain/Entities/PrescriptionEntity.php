<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class PrescriptionEntity
{
    public function __construct(
        public readonly IdObj $doctor_id,
        public readonly IdObj $patient_id,
        public readonly IdObj $appointment_id,
        public readonly ?string $notes,
    ) {}
}
