<?php

namespace App\Http\Controllers;

use App\Application\DTOs\LoginDto;
use App\Application\Utils\ExceptionConstants;
use App\Http\Requests\Auth\LoginRequest;
use App\Domain\Interfaces\Services\AuthServiceInterface;
use App\Application\Utils\SuccessConstants;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthServiceInterface $authServiceInterface) {}

    public function login(LoginRequest $request)
    {
        try {
            if (!$request->validated())
                return failed(ExceptionConstants::VALIDATION);

            $dto = LoginDto::fromArray($request->all());
            $data = $this->authServiceInterface->login($dto);
            return successLogin(SuccessConstants::LOGIN, ['user' => $data['user']]);
        } catch (Exception $e) {
            return failed($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'message' => SuccessConstants::LOGOUT,
            ], Response::HTTP_OK)->withoutCookie('laravel_session');
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
