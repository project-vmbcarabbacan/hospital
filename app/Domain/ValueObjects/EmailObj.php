<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class EmailObj {
    private string $value;

    public function __construct(string $email)
    {
        $email = trim(strtolower($email));

        if (!$this->isValid($email)) {
            throw new InvalidArgumentException("Invalid email address: {$email}");
        }

        $this->value = $email;
    }

    private function isValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(EmailObj $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
