<?php

use App\Domain\ValueObjects\PasswordObj;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    Hash::shouldReceive('make')
        ->andReturnUsing(fn ($value) => 'hashed_' . $value);

    Hash::shouldReceive('check')
        ->andReturnUsing(fn ($value, $hash) => $hash === 'hashed_' . $value);
});

test('creates password with valid rules and hashes it', function () {
    $password = new PasswordObj('Password123', true);
    expect($password->hashed())->toBe('hashed_Password123');
});

test('throws exception for short password', function () {
    new PasswordObj('Pass1', true);
})->throws(InvalidArgumentException::class, 'Password must be at least 8 characters.');

test('throws exception if no uppercase letter', function () {
    new PasswordObj('password123', true);
})->throws(InvalidArgumentException::class, 'Password must contain at least one uppercase letter.');

test('throws exception if no lowercase letter', function () {
    new PasswordObj('PASSWORD123', true);
})->throws(InvalidArgumentException::class, 'Password must contain at least one lowercase letter.');

test('throws exception if no number', function () {
    new PasswordObj('Password', true);
})->throws(InvalidArgumentException::class, 'Password must contain at least one number.');

test('accepts pre-hashed password directly', function () {
    $password = new PasswordObj('hashed_AlreadyHashedPassword', false);
    expect($password->hashed())->toBe('hashed_AlreadyHashedPassword');
});

test('verifies correct password against hash', function () {
    $password = new PasswordObj('Password123', true);
    expect($password->verify('Password123'))->toBeTrue();
    expect($password->verify('WrongPassword'))->toBeFalse();
});

test('compares two password objects for equality', function () {
    $pass1 = new PasswordObj('Password123', true);
    $pass2 = new PasswordObj('Password123', true);
    expect($pass1->equals($pass2))->toBeTrue();

    $pass3 = new PasswordObj('DifferentPass123', true);
    expect($pass1->equals($pass3))->toBeFalse();
});
