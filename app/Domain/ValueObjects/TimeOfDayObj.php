<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;
use Carbon\Carbon;

class TimeOfDayObj
{
    public function __construct(public readonly string $value)
    {
        if (!preg_match('/^(2[0-3]|[01]?[0-9]):([0-5][0-9])$/', $value)) {
            throw new InvalidArgumentException("Invalid time format: $value. Expect HH:MM in 24-hour format.");
        }
    }

    public function hour(): int
    {
        return (int) explode(':', $this->value)[0];
    }

    public function minute(): int
    {
        return (int) explode(':', $this->value)[1];
    }

    public function value(): string
    {
        return $this->value;
    }

    public function compare(TimeOfDayObj $time, bool $isStart = true): string
    {
        $time_1 = Carbon::createFromFormat('H:i', $this->value);
        $time_2 = Carbon::createFromFormat('H:i', $time->value());

        if ($time_1->isBefore($time_2) && $isStart) {
            return $this->value;
        } else if ($time_1->isAfter($time_2) && $isStart) {
            return $time->value();
        } else if ($time_1->isAfter($time_2) && !$isStart) {
            return $this->value;
        } else {
            return $time->value();
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
