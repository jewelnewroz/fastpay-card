<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\LoginRequest;
use App\Http\Requests\API\V1\LoginVerifyRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class ApiAuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->validateLoginRequest($request);
    }

    public function verify(LoginVerifyRequest $request): JsonResponse
    {
        return $this->authService->verifyLoginOtp($request);
    }
}
