<?php

namespace App\Application\DTOs;

use App\Domain\ValueObjects\IdObj;

class UpdateByFieldDto
{
    public function __construct(
        public readonly IdObj $id,
        public readonly string $field,
        public readonly string $value
    ) {}
}
