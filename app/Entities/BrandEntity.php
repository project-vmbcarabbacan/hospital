<?php

namespace App\Entities;

class BrandEntity
{

    public function __construct(
        public readonly string $name,
        public readonly ?string $photo = null,
    ) {}
}
