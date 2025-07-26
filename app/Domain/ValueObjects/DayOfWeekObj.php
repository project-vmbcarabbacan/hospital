<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class DayOfWeekObj
{
    public string $value;

    private const VALID_DAYS = [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday'
    ];

    public function __construct(string $value)
    {
        $normalized = trim(strtolower($value));

        if (!in_array($normalized, self::VALID_DAYS)) {
            throw new InvalidArgumentException("Invalid day of week: $value");
        }

        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function all(): array
    {
        return array_map(fn($day) => new self($day), self::VALID_DAYS);
    }
}
