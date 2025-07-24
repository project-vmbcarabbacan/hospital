<?php

namespace App\Entities;

class ServiceEntity
{

    public function __construct(
        public readonly string $sku,
        public readonly string $name,
        public readonly string $price,
        public readonly bool $status,
        public readonly ?string $photo = null,
    ) {}
}
