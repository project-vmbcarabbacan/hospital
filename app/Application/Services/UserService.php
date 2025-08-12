<?php

namespace App\Application\Services;

use App\Domain\Interfaces\Repositories\RatingRepositoryInterface;
use App\Domain\Interfaces\Repositories\UserRepositoryInterface;
use App\Domain\Interfaces\Services\UserServiceInterface;
use App\Domain\ValueObjects\IdObj;

class UserService implements UserServiceInterface
{

    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected RatingRepositoryInterface $ratingRepositoryInterface
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
}
