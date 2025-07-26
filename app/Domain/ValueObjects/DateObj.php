<?php

namespace App\Domain\ValueObjects;

use Carbon\Carbon;
use InvalidArgumentException;
use DateTimeImmutable;

class DateObj
{
    public function __construct(public readonly string $value)
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $value);

        if (!$date || $date->format('Y-m-d') !== $value) {
            throw new InvalidArgumentException("Invalid date format: $value. Expected format: Y-m-d");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toCarbon(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d', $this->value);
    }

    public function equals(DateObj $other): bool
    {
        return $this->value === $other->value();
    }

    public function isBefore(DateObj $other): bool
    {
        return $this->toCarbon()->lessThan($other->toCarbon());
    }

    public function isAfter(DateObj $other): bool
    {
        return $this->toCarbon()->greaterThan($other->toCarbon());
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
