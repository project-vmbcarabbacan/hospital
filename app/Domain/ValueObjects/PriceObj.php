<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class PriceObj
{
    public function __construct(
        public readonly float $value
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException("Price cannot be negative.");
        }
    }

    public function formatted(string $currency = 'AED'): string
    {
        return number_format($this->value, 2) . ' ' . $currency;
    }

    public function display(): string {
        return number_format($this->value, 2, '.', ',');
    }

    public function value(): string
    {
        return number_format($this->value, 2, '.', '');
    }
}
