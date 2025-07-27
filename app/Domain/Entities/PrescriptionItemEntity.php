<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class PrescriptionItemEntity
{
    public function __construct(
        public readonly IdObj $prescription_id,
        public readonly string $medicine,
        public readonly string $dosage,
        public readonly string $instructions,
    ) {}
}
