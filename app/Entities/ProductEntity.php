<?php

namespace App\Entities;

class ProductEntity
{
    public function __construct(
        public readonly int $distributor_id,
        public readonly int $brand_id,
        public readonly string $sku,
        public readonly string $name,
        public readonly float $price,
        public readonly int $stocks,
        public readonly bool $status,
        public readonly ?string $photo = null,
    ) {}
}
