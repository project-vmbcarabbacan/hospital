<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class RatingEntity
{
    public function __construct(
        public readonly IdObj $doctor_id,
        public readonly IdObj $patient_id,
        public readonly int $rating,
        public readonly string $comment,
        public readonly bool $is_approved,
    ) {}
}
