<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenAbility
{
    public function handle(Request $request, Closure $next, ...$abilities): Response
    {
        $token = $request->user()?->currentAccessToken();
        // If it's a TransientToken, abilities don't apply
        if (!$token || !method_exists($token, 'canAny') || !$token->canAny($abilities)) {
            return failed('Unauthorized: missing required ability', [], 403);
        }

        return $next($request);
    }
}
