<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class UpdateByFieldEntity
{

    public function __construct(
        public readonly IdObj $id,
        public readonly string $field,
        public readonly string $value
    ) {}
}
