<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class SpecializationEntity {

    public function __construct(
        public readonly IdObj $department_id,
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly ?string $photo = null,
    ){}
}
