<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\ValueObjects\IdObj;

interface UserSpecializationAchievementsInterface
{
    public function doctorSpecialization(IdObj $user_id, IdObj $specialization_id);
}
