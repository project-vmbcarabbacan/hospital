<?php

use App\Application\Services\UserService;
use App\Domain\Interfaces\Repositories\UserRepositoryInterface;
use App\Domain\ValueObjects\IdObj;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use function Pest\Laravel\actingAs;


it('returns the current user with photo and without information', function () {
    // Fake authenticated user
    $user = \App\Models\User::factory()->create();

    actingAs($user);

    // Mock user domain entity with nested information
    $userEntity = new stdClass();
    $userEntity->id = $user->id;
    $userEntity->name = $user->name;

    $userEntity->information = new stdClass();
    $userEntity->information->profile_photo = 'photo.jpg';

    // Mock repository
    $mockRepo = mock(UserRepositoryInterface::class);
    $mockRepo->shouldReceive('findById')
        ->once()
        ->withArgs(function (IdObj $idObj) use ($user) {
            return $idObj->equals(new IdObj($user->id));
        })
        ->andReturn($userEntity);

    $service = new UserService($mockRepo);

    $result = $service->currentUser();

    expect($result->photo)->toBe('photo.jpg');
    expect(isset($result->information))->toBeFalse();
});
