<?php

namespace App\Infrastructure\Repositories;

use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\AchievementEntity;
use App\Domain\Interfaces\Repositories\UserSpecializationAchievementRepositoryInterface;
use App\Domain\ValueObjects\IdObj;
use App\Models\Achievement;
use App\Models\DoctorSpecialization;
use Exception;

class UserSpecializationAchievementRepository implements UserSpecializationAchievementRepositoryInterface
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

    public function addAchievement(AchievementEntity $data)
    {
        try {
            return Achievement::create([
                'user_id' => $data->user_id->value(),
                'title' => $data->title,
                'description' => $data->description,
                'year_awarded' => $data->year_awarded,
            ])->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateAchievement(IdObj $id, AchievementEntity $data)
    {
        try {
            $achievement = $this->getAchievementById($id);
            if (!$achievement)
                throw new Exception(ExceptionConstants::ACHIEVEMENT_NOT_FOUND);

            $updates = array_filter([
                'user_id' => $data->user_id->value(),
                'title' => $data->title,
                'description' => $data->description,
                'year_awarded' => $data->year_awarded,
            ], fn($value) => !is_null($value));

            $achievement->update($updates);

            return $achievement->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getAchievementById(IdObj $id)
    {
        return Achievement::find($id->value());
    }

    protected function checkDoctorAndSpecializationExist(IdObj $user_id, IdObj $specialization_id)
    {
        return DoctorSpecialization::where([
            'user_id' => $user_id->value(),
            'specialization_id' => $specialization_id->value()
        ])->exists();
    }
}
