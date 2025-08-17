<?php

namespace App\Application\DTOs;

use App\Domain\ValueObjects\IdObj;

class UploadAvatarDto
{
    public function __construct(
        public readonly IdObj $user_id,
        public readonly string $path,
    ) {}
}
