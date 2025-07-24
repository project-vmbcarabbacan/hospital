<?php

namespace App\Http\Controllers;

use App\Application\DTOs\LoginDto;
use App\Domain\Enums\AuthEnum;
use App\Domain\ValueObjects\EmailObj;
use App\Http\Requests\Auth\LoginRequest;
use App\Domain\Interfaces\Services\AuthServiceInterface;
use App\Application\Utils\SuccessConstants;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(protected AuthServiceInterface $authServiceInterface) {}

    public function login(Request $request)
    {
        try {
            $dto = LoginDto::fromArray($request->all());
            $data = $this->authServiceInterface->login($dto);
            return successLogin(SuccessConstants::LOGIN, ['user' => $data['user']], $data['token']);

        } catch (Exception $e) {
            return failed($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $token = $request->user('sanctum')->currentAccessToken();

            if ($token && method_exists($token, 'delete')) {
                $token->delete();
            }

            return response()->json([
                'message' => SuccessConstants::LOGOUT,
            ], Response::HTTP_OK)->withoutCookie('auth_token');
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
