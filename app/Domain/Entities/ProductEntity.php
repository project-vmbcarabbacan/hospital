<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\PriceObj;
use App\Domain\ValueObjects\SkuObj;
use App\Domain\ValueObjects\StockObj;

class ProductEntity
{
    public function __construct(
        public readonly IdObj $distributor_id,
        public readonly IdObj $brand_id,
        public readonly SkuObj $sku,
        public readonly string $name,
        public readonly PriceObj $price,
        public readonly StockObj $stocks,
        public readonly bool $status,
        public readonly ?string $photo = null,
    ) {}
}
