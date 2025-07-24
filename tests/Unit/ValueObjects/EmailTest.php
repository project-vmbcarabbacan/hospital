<?php

use App\Domain\ValueObjects\EmailObj;

it('creates a valid email object', function () {
    $email = new EmailObj('Test@Example.com');

    expect($email->value())->toBe('test@example.com');
    expect((string) $email)->toBe('test@example.com');
});

it('throws an exception for invalid email format', function () {
    expect(fn () => new EmailObj('not-an-email'))
        ->toThrow(InvalidArgumentException::class);
});

it('trims and lowercases the email address', function () {
    $email = new EmailObj('  USER@Example.COM  ');

    expect($email->value())->toBe('user@example.com');
});

it('correctly compares two equal email objects', function () {
    $email1 = new EmailObj('User@Example.com');
    $email2 = new EmailObj('user@example.com');

    expect($email1->equals($email2))->toBeTrue();
});

it('detects inequality between different emails', function () {
    $email1 = new EmailObj('user1@example.com');
    $email2 = new EmailObj('user2@example.com');

    expect($email1->equals($email2))->toBeFalse();
});
