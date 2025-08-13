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

    public function getDays()
    {
        if (!$this->value)
            return '';

        $fromDate = Carbon::parse($this->value);
        $toDate = Carbon::now();

        $diff = $fromDate->diff($toDate);

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        if ($days > 0 && $years === 0)
            return $months . ($months > 1 ? "months " : "month ") . $days . ($days > 1 ? "days" : "day");
        else
            return $years . ($years > 1 ? "years " : "year ") . $months . ($months > 1 ? "months" : "month");
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
