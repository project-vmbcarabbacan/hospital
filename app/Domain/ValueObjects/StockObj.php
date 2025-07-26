<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class StockObj
{
    public function __construct(
        public readonly int $value
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException("Stock cannot be negative.");
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
