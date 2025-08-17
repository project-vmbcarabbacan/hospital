<?php

namespace App\Application\Services;

use App\Application\DTOs\AchievementAddDto;
use App\Application\DTOs\UpdateByFieldDto;
use App\Domain\Entities\AchievementEntity;
use App\Domain\Entities\UpdateByFieldEntity;
use App\Domain\Interfaces\Repositories\RatingRepositoryInterface;
use App\Domain\Interfaces\Repositories\UserRepositoryInterface;
use App\Domain\Interfaces\Repositories\UserSpecializationAchievementRepositoryInterface;
use App\Domain\Interfaces\Services\UserServiceInterface;
use App\Domain\ValueObjects\IdObj;

class UserService implements UserServiceInterface
{

    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected RatingRepositoryInterface $ratingRepositoryInterface,
        protected UserSpecializationAchievementRepositoryInterface $userSpecializationAchievementRepositoryInterface
    ) {}

    public function currentUser()
    {
        $user = $this->userRepository->findById(new IdObj(auth()->user()->id));
        $user->photo = $user->information && $user->information->profile_photo ? $user->information->profile_photo : '';

        unset($user->information);

        return $user;
    }

    public function getUserProfileByUserId(IdObj $id)
    {
        return $this->userRepository->findById($id);
    }

    public function getRating(IdObj $userId)
    {
        return $this->ratingRepositoryInterface->getAverageByDoctorId($userId);
    }

    public function updateUserProfileByField(UpdateByFieldDto $dto)
    {
        $entity = new UpdateByFieldEntity(
            id: $dto->id,
            field: $dto->field,
            value: $dto->value,
        );

        $this->userRepository->updateProfileById($entity);
    }

    public function achievementAdd(AchievementAddDto $dto)
    {
        $entity = new AchievementEntity(
            user_id: $dto->user_id,
            title: $dto->title,
            description: $dto->description,
            year_awarded: $dto->year_awarded,
        );

        return $this->userSpecializationAchievementRepositoryInterface->addAchievement($entity);
    }
}
