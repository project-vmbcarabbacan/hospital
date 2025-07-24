<?php

use App\Domain\ValueObjects\IdObj;

it('creates a valid id object', function () {
    $id = new IdObj(123);
    expect($id->value())->toBe(123);
});

it('throws exception for zero or negative id', function () {
    new IdObj(0);
})->throws(InvalidArgumentException::class, 'ID must be a positive integer.');

it('compares id objects correctly', function () {
    $id1 = new IdObj(1);
    $id2 = new IdObj(1);
    $id3 = new IdObj(2);

    expect($id1->equals($id2))->toBeTrue()
        ->and($id1->equals($id3))->toBeFalse();
});
