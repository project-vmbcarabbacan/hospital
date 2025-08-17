<?php

namespace App\Application\DTOs;

use App\Domain\ValueObjects\IdObj;

class AchievementAddDto
{

    public function __construct(
        public readonly IdObj $user_id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $year_awarded,
    ) {}
}
