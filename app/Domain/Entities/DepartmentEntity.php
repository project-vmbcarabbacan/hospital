<?php

namespace App\Domain\Entities;

class DepartmentEntity {

    public function __construct(
        public readonly string $name,
        public readonly ?int $id = null,
        public readonly ?string $description = null,
    ){}
}
