<?php

namespace App\Http\Controllers;

use App\Application\DTOs\UpdateByFieldDto;
use App\Application\Utils\ExceptionConstants;
use App\Application\Utils\SuccessConstants;
use App\Domain\Interfaces\Services\RoleServiceInterface;
use App\Domain\Interfaces\Services\UserServiceInterface;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\RoleIdObj;
use App\Http\Requests\Profile\UpdateByField;
use App\Http\Resources\UserProfileResource;
use Exception;

class UserController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userServiceInterface,
        protected RoleServiceInterface $roleServiceInterface
    ) {}

    public function currentUser()
    {
        try {
            $user = $this->userServiceInterface->currentUser();

            return success(SuccessConstants::CURRENT_USER, ['user' => $user]);
        } catch (Exception $e) {
            return failed($e->getMessage());
        }
    }

    public function userProfileById($id)
    {
        try {
            $userProfile = $this->userServiceInterface->getUserProfileByUserId(new IdObj($id));
            $roleName = $this->roleServiceInterface->getRoleName(new RoleIdObj($userProfile->role_id));
            $rating = $this->userServiceInterface->getRating(new IdObj($userProfile->id));
            return success(SuccessConstants::USER_PROFILE, new UserProfileResource($userProfile, $roleName, $rating));
        } catch (Exception $e) {
            return failed($e->getMessage());
        }
    }

    public function updateProfile(UpdateByField $request)
    {
        if (!$request->validated())
            return failed(ExceptionConstants::VALIDATION);

        try {
            $dto = new UpdateByFieldDto(
                id: new IdObj($request->user_id),
                field: $request->field,
                value: $request->value,
            );

            $this->userServiceInterface->updateUserProfileByField($dto);
        } catch (Exception $e) {
            return failed($e->getMessage());
        }
    }
}
