<?php


if (!function_exists('successLogin')) {

    function successLogin($message, $data = [], $token = '')
    {
        return response()->json(['message' => $message, 'data' => $data], 200)->cookie(
            'laravel_session',
            $token,
            60 * 24, // 1 day
            '/',
            null,
            true, // Secure
            true, // HttpOnly
            false,
            'Strict'
        );
    }
}

if (!function_exists('success')) {

    function success($message, $data = [], $status = 200)
    {
        return response()->json(['message' => $message, 'data' => $data], $status);
    }
}

if (!function_exists('failed')) {

    function failed($message, $data = [], $status = 422)
    {
        return response()->json(['message' => $message, 'data' => $data], $status);
    }
}
