<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class ProductEntity {
    public function __construct(
        public readonly IdObj $distributor_id,
        public readonly IdObj $brand_id,
        public readonly string $sku,
        public readonly string $name,
        public readonly float $price,
        public readonly int $stocks,
        public readonly bool $status,
        public readonly ?string $photo = null,
    ){}
}
