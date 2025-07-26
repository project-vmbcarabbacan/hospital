<?php

use App\Domain\ValueObjects\StockObj;

it('creates a valid stock', function () {
    $stock = new StockObj(49);

    expect($stock->value())->toBe(49);
});

it('throws exception for negative stock', function () {
    new StockObj(-5);
})->throws(InvalidArgumentException::class, 'Stock cannot be negative.');
