<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Interfaces\Repositories\UserSpecializationAchievementsInterface;
use App\Domain\ValueObjects\IdObj;
use App\Models\DoctorSpecialization;

class UserSpecializationAchievements implements UserSpecializationAchievementsInterface
{

    public function doctorSpecialization(IdObj $user_id, IdObj $specialization_id)
    {
        if ($this->checkDoctorAndSpecializationExist($user_id, $specialization_id))
            return;

        return DoctorSpecialization::create([
            'user_id' => $user_id->value(),
            'specialization_id' => $specialization_id->value()
        ])->refresh();
    }

    protected function checkDoctorAndSpecializationExist(IdObj $user_id, IdObj $specialization_id)
    {
        return DoctorSpecialization::where([
            'user_id' => $user_id->value(),
            'specialization_id' => $specialization_id->value()
        ])->exists();
    }
}
