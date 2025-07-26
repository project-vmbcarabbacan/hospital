<?php

use App\Domain\ValueObjects\PriceObj;

it('creates a valid price', function () {
    $price = new PriceObj(49.99);

    expect($price->value())->toBe('49.99');
    expect($price->formatted('PHP'))->toBe('49.99 PHP');
});

it('throws exception for negative price', function () {
    new PriceObj(-5.00);
})->throws(InvalidArgumentException::class, 'Price cannot be negative.');
