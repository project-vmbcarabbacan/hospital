<?php

namespace App\Domain\ValueObjects;

use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class PasswordObj {
    private string $hashed;

    public function __construct(string $plainPassword, bool $hashed = false)
    {
        if (!$hashed) {
            $this->hashed = $plainPassword;
        } else {
            $this->validate($plainPassword);
            $this->hashed = Hash::make($plainPassword);
        }
    }

    private function validate(string $password): void
    {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters.');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one uppercase letter.');
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one lowercase letter.');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one number.');
        }
    }

    public function hashed(): string
    {
        return $this->hashed;
    }

    public function verify(string $plainPassword): bool
    {
        return Hash::check($plainPassword, $this->hashed);
    }

    public function value(): string
    {
        return $this->hashed;
    }

    public function equals(PasswordObj $other): bool
    {
        return $this->hashed === $other->hashed();
    }

}
