<?php

use App\Domain\ValueObjects\DayOfWeekObj;

it('accepts a valid day', function () {
    expect(new DayOfWeekObj('monday')->value())->toBe('monday');
    expect(new DayOfWeekObj('SUNDAY')->value())->toBe('sunday');
});

it('rejects an invalid day', function () {
    new DayOfWeekObj('funday');
})->throws(InvalidArgumentException::class, 'Invalid day of week: funday');

it('provides all valid days', function () {
    $days = DayOfWeekObj::all();
    expect($days)->toHaveCount(7);
    expect($days[0]->value())->toBe('monday');
});
