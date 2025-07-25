<?php

namespace App\Application\DTOs;

use App\Domain\ValueObjects\IdObj;

class CreateDepartmentDto
{
    public function __construct(
        public readonly string $name,
        public readonly ?IdObj $head_doctor_id = null,
        public readonly ?string $description = null,
        public readonly ?string $photo = null,
        public readonly ?string $working_hours = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            head_doctor_id: new IdObj($data['head_doctor_id']) ?? null,
            description: $data['description'] ?? null,
            photo: $data['photo'] ?? null,
            working_hours: $data['working_hours'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'head_doctor_id' => $this->head_doctor_id,
            'description' => $this->description,
            'photo' => $this->photo,
            'working_hours' => $this->working_hours,
        ], fn($value) => $value != null);
    }
}
