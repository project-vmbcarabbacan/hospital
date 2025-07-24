<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class NameObj {
    private string $value;

    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            throw new InvalidArgumentException("Name cannot be empty.");
        }

        if (strlen($trimmed) > 100) {
            throw new InvalidArgumentException("Name cannot exceed 100 characters.");
        }

        $this->value = $trimmed;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(NameObj $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
