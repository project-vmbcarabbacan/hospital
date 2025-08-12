<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;


Route::post('login', [AuthController::class, 'login']);

Route::group([
    'prefix' => 'hpt',
    'middleware' => [
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        'auth:sanctum'
    ],
    'as' => 'hpt.', // Route name prefix
], function () {
    Route::get('/user', [UserController::class, 'currentUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
