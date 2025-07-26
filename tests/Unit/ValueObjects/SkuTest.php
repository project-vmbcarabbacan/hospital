<?php

use App\Domain\ValueObjects\SkuObj;

it('creates a valid SKU', function () {
    $sku = new SkuObj('ABC-123');

    expect((string) $sku)->toBe('ABC-123');
});

it('throws an exception for empty SKU', function () {
    new SkuObj('');
})->throws(InvalidArgumentException::class, 'SKU cannot be empty.');

it('throws an exception for invalid SKU format', function () {
    new SkuObj('abc@#123');
})->throws(InvalidArgumentException::class, 'SKU format is invalid.');
