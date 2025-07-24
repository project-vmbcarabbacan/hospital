<?php

use App\Domain\ValueObjects\NameObj;

it('creates a valid name object', function () {
    $name = new NameObj('John Doe');
    expect($name->value())->toBe('John Doe');
});

it('throws exception for empty name', function () {
    new NameObj('');
})->throws(InvalidArgumentException::class, 'Name cannot be empty.');

it('throws exception for overly long name', function () {
    new NameObj(str_repeat('a', 101));
})->throws(InvalidArgumentException::class, 'Name cannot exceed 100 characters.');

it('correctly compares two name objects', function () {
    $a = new NameObj('John');
    $b = new NameObj('John');
    $c = new NameObj('Jane');
    expect($a->equals($b))->toBeTrue()
        ->and($a->equals($c))->toBeFalse();
});
