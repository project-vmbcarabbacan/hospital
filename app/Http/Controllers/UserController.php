<?php

namespace App\Http\Controllers;

use App\Application\Utils\ExceptionConstants;
use App\Application\Utils\SuccessConstants;
use App\Domain\Interfaces\Services\UserServiceInterface;
use App\Domain\ValueObjects\IdObj;
use App\Http\Requests\ID\UserIdRequest;
use Exception;

class UserController extends Controller
{
    public function __construct(protected UserServiceInterface $userServiceInterface) {}

    public function currentUser()
    {
        try {
            $user = $this->userServiceInterface->currentUser();

            return success(SuccessConstants::CURRENT_USER, ['user' => $user]);
        } catch (Exception $e) {
            return failed($e->getMessage());
        }
    }

    public function userProfileById(UserIdRequest $request)
    {
        try {
            if (!$request->validated())
                return failed(ExceptionConstants::VALIDATION);

            $userProfile = $this->userServiceInterface->getUserProfileByUserId(new IdObj($request->user_id));

            return success(SuccessConstants::USER_PROFILE, ['user' => $userProfile]);
        } catch (Exception $e) {
            return failed($e->getMessage());
        }
    }
}
