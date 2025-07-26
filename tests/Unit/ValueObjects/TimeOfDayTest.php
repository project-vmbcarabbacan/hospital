<?php

use App\Domain\ValueObjects\TimeOfDayObj;

it('accepts valid time formats', function () {
    expect((string) new TimeOfDayObj('09:30'))->toBe('09:30');
    expect((string) new TimeOfDayObj('23:59'))->toBe('23:59');
});

it('extracts hour and minute', function () {
    $time = new TimeOfDayObj('08:45');
    expect($time->hour())->toBe(8);
    expect($time->minute())->toBe(45);
});

it('rejects invalid time formats', function () {
    new TimeOfDayObj('24:00');
})->throws(InvalidArgumentException::class);

it('rejects non-time strings', function () {
    new TimeOfDayObj('hello');
})->throws(InvalidArgumentException::class);
