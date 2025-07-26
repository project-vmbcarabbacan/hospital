<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\AchievementEntity;
use App\Domain\ValueObjects\IdObj;

interface UserSpecializationAchievementRepositoryInterface
{
    public function doctorSpecialization(IdObj $user_id, IdObj $specialization_id);
    public function addAchievement(AchievementEntity $data);
    public function updateAchievement(IdObj $id, AchievementEntity $data);
    public function getAchievementById(IdObj $id);
}
