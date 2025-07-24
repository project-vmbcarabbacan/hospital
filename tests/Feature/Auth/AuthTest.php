<?php

use App\Domain\Enums\RoleEnum;
use App\Models\User;
use App\Application\Utils\ExceptionConstants;
use App\Application\Utils\SuccessConstants;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;


beforeEach(function () {
    $role_id = RoleEnum::SUPER_ADMIN;
    $this->user = User::factory()->create([
        'email' => 'test@domain.com',
        'password' => Hash::make('Password123'),
        'role_id' => $role_id->value,
    ]);
});

function loginUser(): \Illuminate\Testing\TestResponse
{
    $response = test()->postJson('/api/login', [
        'email' => 'test@domain.com',
        'password' => 'Password123',
    ]);

    $response->assertOk()->assertCookie('auth_token');

    return $response;
}

it('allows user to login and receive cookie token', function () {
    $response = loginUser();

    $response->assertOk()
        ->assertJson(
            fn(AssertableJson $json) =>
            $json->where('message', SuccessConstants::LOGIN)
                ->has('data')
                ->etc()
        )
        ->assertCookie('auth_token');
});

it('rejects login with invalid credentials', function () {
    $response = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => 'Wrong-password123',
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'message' => ExceptionConstants::LOGIN_INVALID,
        ]);
});

it('logs out the user with valid cookie token', function () {
    $loginResponse = test()->postJson('/api/login', [
        'email' => 'test@domain.com',
        'password' => 'Password123',
    ]);

    $authCookie = collect($loginResponse->headers->getCookies())
        ->first(fn($cookie) => $cookie->getName() === 'auth_token');

    expect($authCookie)->not->toBeNull();

    $token = $authCookie->getValue();

    $logoutResponse = test()->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/hpt/logout');

    $logoutResponse->assertOk()
        ->assertJson([
            'message' => SuccessConstants::LOGOUT,
        ]);
});

it('rejects logout without auth token', function () {
    $response = $this->postJson('/api/hpt/logout');

    $response->assertUnauthorized();
});
