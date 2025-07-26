<?php

use App\Domain\ValueObjects\DateObj;
use Carbon\Carbon;

it('creates a valid date object', function () {
    $date = new DateObj('2025-07-23');
    expect($date->value())->toBe('2025-07-23');
});

it('converts to Carbon instance', function () {
    $date = new DateObj('2025-07-23');
    expect($date->toCarbon())->toBeInstanceOf(Carbon::class);
    expect($date->toCarbon()->format('Y-m-d'))->toBe('2025-07-23');
});

it('compares equality correctly', function () {
    $date1 = new DateObj('2025-07-23');
    $date2 = new DateObj('2025-07-23');
    $date3 = new DateObj('2025-07-24');

    expect($date1->equals($date2))->toBeTrue();
    expect($date1->equals($date3))->toBeFalse();
});

it('returns true if date is before another', function () {
    $earlier = new DateObj('2025-07-22');
    $later = new DateObj('2025-07-23');

    expect($earlier->isBefore($later))->toBeTrue();
    expect($later->isBefore($earlier))->toBeFalse();
});

it('returns true if date is after another', function () {
    $earlier = new DateObj('2025-07-22');
    $later = new DateObj('2025-07-23');

    expect($later->isAfter($earlier))->toBeTrue();
    expect($earlier->isAfter($later))->toBeFalse();
});

it('throws exception for invalid date format (wrong format)', function () {
    new DateObj('23-07-2025'); // d-m-Y
})->throws(InvalidArgumentException::class, 'Invalid date format: 23-07-2025. Expected format: Y-m-d');

it('throws exception for invalid date format (invalid month)', function () {
    new DateObj('2025-13-23');
})->throws(InvalidArgumentException::class, 'Invalid date format: 2025-13-23. Expected format: Y-m-d');

it('throws exception for invalid date format (invalid day)', function () {
    new DateObj('2025-02-30');
})->throws(InvalidArgumentException::class, 'Invalid date format: 2025-02-30. Expected format: Y-m-d');
