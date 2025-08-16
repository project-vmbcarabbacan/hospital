<?php

namespace App\Domain\Interfaces\Services;

use App\Application\DTOs\UpdateByFieldDto;
use App\Domain\ValueObjects\IdObj;

interface UserServiceInterface
{
    public function currentUser();
    public function getUserProfileByUserId(IdObj $id);
    public function getRating(IdObj $userId);
    public function updateUserProfileByField(UpdateByFieldDto $dto);
}
