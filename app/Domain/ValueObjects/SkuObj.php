<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class SkuObj
{
    public function __construct(
        public readonly string $value
    ) {
        if (trim($value) === '') {
            throw new InvalidArgumentException("SKU cannot be empty.");
        }

        if (!preg_match('/^[A-Z0-9\-]+$/', $value)) {
            throw new InvalidArgumentException("SKU format is invalid.");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
