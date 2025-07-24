<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class RoleIdObj {
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0 && $value > 12) {
            throw new InvalidArgumentException("Role id must be a positive integer and not greater than 12");
        }

        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(RoleIdObj $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
