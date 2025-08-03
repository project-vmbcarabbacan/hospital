<?php

use App\Domain\Enums\RoleEnum;
use App\Models\User;
use App\Application\Utils\ExceptionConstants;
use App\Application\Utils\SuccessConstants;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Facades\Cookie;


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

    $response->assertOk()->assertCookie('laravel_session');

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
        ->assertCookie('laravel_session');
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

// it('logs out the user with valid cookie token', function () {
//     // Step 1: Get CSRF cookie (required before login)
//     $csrfResponse = test()->get('/sanctum/csrf-cookie');

//     // Extract CSRF token from the cookie (XSRF-TOKEN is what Laravel expects)
//     $csrfCookie = collect($csrfResponse->headers->getCookies())
//         ->first(fn($cookie) => $cookie->getName() === 'XSRF-TOKEN');

//     expect($csrfCookie)->not->toBeNull();

//     // Step 2: Login
//     $loginResponse = test()
//         ->withCookie('XSRF-TOKEN', $csrfCookie->getValue()) // Provide CSRF token as cookie too
//         ->withHeader('X-XSRF-TOKEN', $csrfCookie->getValue()) // Match header with cookie
//         ->postJson('/api/login', [
//             'email' => 'test@domain.com',
//             'password' => 'Password123',
//         ]);

//     // Get session cookie after login
//     $sessionCookie = collect($loginResponse->headers->getCookies())
//         ->first(fn($cookie) => $cookie->getName() === 'laravel_session');

//     expect($sessionCookie)->not->toBeNull();

//     // Step 3: Call logout with both cookies + header
//     $logoutResponse = test()
//         ->withCookie('laravel_session', $sessionCookie->getValue())
//         ->withCookie('XSRF-TOKEN', $csrfCookie->getValue())
//         ->withHeader('X-XSRF-TOKEN', $csrfCookie->getValue())
//         ->postJson('/api/hpt/logout');

//     $logoutResponse->assertOk()
//         ->assertJson([
//             'message' => SuccessConstants::LOGOUT,
//         ]);
// });

it('rejects logout without auth token', function () {
    $response = $this->postJson('/api/hpt/logout');

    $response->assertUnauthorized();
});
