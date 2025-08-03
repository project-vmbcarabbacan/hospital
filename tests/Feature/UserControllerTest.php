<?php

use App\Domain\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use App\Application\Utils\SuccessConstants;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

it('returns current user successfully', function () {
    // Create and login a user
    $user = User::factory()->create();
    actingAs($user);

    // Mock expected return value from UserServiceInterface
    $userDto = new stdClass();
    $userDto->id = $user->id;
    $userDto->name = $user->name;
    $userDto->email = $user->email;
    $userDto->photo = 'profile.jpg';

    // Bind mock into container
    $mockService = mock(UserServiceInterface::class);
    $mockService->shouldReceive('currentUser')
        ->once()
        ->andReturn($userDto);

    app()->instance(UserServiceInterface::class, $mockService);

    // Define the route if not already defined
    Route::get('/api/hpt/user', [\App\Http\Controllers\UserController::class, 'currentUser']);

    // Call the endpoint
    $response = getJson('/api/hpt/user');

    $response->assertOk()
        ->assertJson(
            fn(AssertableJson $json) =>
            $json->where('message', SuccessConstants::CURRENT_USER)
                ->has('data.user')
                ->etc()
        );
});
