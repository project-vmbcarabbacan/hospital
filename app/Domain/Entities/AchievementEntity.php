<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\IdObj;

class  AchievementEntity
{
    public function __construct(
        public readonly IdObj $user_id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $year_awarded,
    ) {}
}
