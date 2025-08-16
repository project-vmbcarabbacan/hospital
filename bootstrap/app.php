<?php

use App\Http\Middleware\CheckTokenAbility;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Request;

use App\Http\Middleware\SanitizeRequest;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(
                'web',
                'auth:sanctum',
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
            )->namespace('Profile')->prefix('profile')->name('profile.')->group(base_path('routes/profile.php'));
            Route::middleware(
                'web',
                'auth:sanctum',
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
            )->namespace('Schedule')->prefix('schedule')->name('schedule.')->group(base_path('routes/schedule.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
        $middleware->append(SanitizeRequest::class);

        $middleware->alias([
            'ability' => CheckTokenAbility::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // ✅ Log all exceptions to a custom channel
        $exceptions->report(function (Throwable $e) {
            // Example: custom logging
            logger()->channel('daily')->error($e->getMessage(), ['exception' => $e]);
        });
    })->create();
