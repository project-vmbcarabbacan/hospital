<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class DepartmentEntity
{

    public function __construct(
        public readonly string $name,
        public readonly ?IdObj $id = null,
        public readonly ?IdObj $head_doctor_id = null,
        public readonly ?string $description = null,
        public readonly ?string $photo = null,
        public readonly ?string $working_hours = null,
    ) {}
}
