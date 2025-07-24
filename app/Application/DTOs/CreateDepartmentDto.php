<?php

namespace App\Application\DTOs;

class CreateDepartmentDto {
    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
        );
    }

    public function toArray(): array {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
        ], fn($value) => $value != null);
    }
}
