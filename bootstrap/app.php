<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Request;

use App\Http\Middleware\SanitizeRequest;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
        $middleware->append(SanitizeRequest::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // ✅ Log all exceptions to a custom channel
        $exceptions->report(function (Throwable $e) {
            // Example: custom logging
            logger()->channel('daily')->error($e->getMessage(), ['exception' => $e]);
        });
    })->create();
