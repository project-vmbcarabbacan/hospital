<?php

namespace App\Application\DTOs;

use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\PasswordObj;

class CreateUserDto {
    public function __construct(
        public readonly string $name,
        public readonly EmailObj $email,
        public readonly PasswordObj $password,
        public readonly int $role_id,
        public readonly string $status,
        public readonly ?int $specialization_id = null,
        public readonly string $phone,
        public readonly ?string $address = null,
        public readonly ?string $birthdate = null,
        public readonly ?string $gender = null,
        public readonly ?string $profile_photo = null,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: new EmailObj($data['email']),
            password: new PasswordObj($data['password'], true),
            role_id: $data['role_id'],
            status: $data['status'],
            phone: $data['phone'],
            specialization_id: $data['specialization_id'] ?? null,
            address: $data['address'],
            birthdate: $data['birthdate'],
            gender: $data['gender'],
            profile_photo: $data['profile_photo'],
        );
    }

    public function toArray(): array {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email->value(),
            'password' => $this->password->value(),
            'role_id' => $this->role_id,
            'status' => $this->status,
            'phone' => $this->phone,
            'specialization_id' => $this->specialization_id,
            'address' => $this->address,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'profile_photo' => $this->profile_photo,
        ], fn($value) => $value != null);
    }
}
