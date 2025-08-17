<?php

namespace App\Http\Controllers;

use App\Application\DTOs\UpdateByFieldDto;
use App\Application\DTOs\UploadAvatarDto;
use App\Application\Utils\ExceptionConstants;
use App\Application\Utils\SuccessConstants;
use App\Domain\Interfaces\Services\ImageServiceInterface;
use App\Domain\Interfaces\Services\UserServiceInterface;
use App\Domain\ValueObjects\FileValueObj;
use App\Domain\ValueObjects\IdObj;
use App\Http\Requests\Image\AvatarUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImageController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService,
        protected ImageServiceInterface $imageService
    ) {}

    public function uploadAvatar(AvatarUpload $request)
    {
        if (!$request->validated())
            return failed(ExceptionConstants::VALIDATION);

        $file = new FileValueObj($request->file('avatar'));
        $path = $file->store('avatar');
        $disk = 'public';
        try {

            $dto = new UpdateByFieldDto(
                id: new IdObj($request->user_id),
                field: 'profilePhoto',
                value: $path
            );

            DB::transaction(function () use ($dto, $disk) {
                $user = $this->userService->getUserProfileByUserId($dto->id);
                $this->imageService->deletePreviousImage($user->information->profile_photo, $disk);
                $this->userService->updateUserProfileByField($dto);
            });

            return success(SuccessConstants::AVATAR_UPLOAD, ['path' => $file->getUrl()]);
        } catch (Throwable $e) {
            // Storage::disk($disk)->delete($path);
            return failed(ExceptionConstants::IMAGE_AVATAR_FAILED, [], 500);
        }
    }
}
