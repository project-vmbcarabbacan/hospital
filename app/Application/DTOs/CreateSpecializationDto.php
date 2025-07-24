<?php

namespace App\Application\DTOs;

use App\Domain\ValueObjects\IdObj;

class CreateSpecializationDto {
    public function __construct(
        public readonly IdObj $department_id,
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly ?string $photo = null,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            department_id: new IdObj($data['department_id']),
            name: $data['name'],
            description: $data['description'] ?? null,
            photo: $data['photo'] ?? null,
        );
    }

    public function toArray(): array {
        return array_filter([
            'department_id' => $this->department_id,
            'name' => $this->name,
            'description' => $this->description,
            'photo' => $this->photo,
        ], fn($value) => $value != null);
    }
}
