<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $sanitized = $this->sanitize($request->all());

        // Replace request data
        $request->merge($sanitized);

        return $next($request);
    }

    private function sanitize($input)
    {
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                // Trim, remove tags and optionally encode special chars
                $input[$key] = trim(strip_tags($value));
            } elseif (is_array($value)) {
                $input[$key] = $this->sanitize($value); // recursive
            }
        }
        return $input;
    }
}
