<?php

namespace App\Services;

use App\Helper\CommonHelper;
use App\Helper\ResponseHelper;
use App\Http\Requests\API\V1\LoginRequest;
use App\Http\Requests\API\V1\LoginVerifyRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateLoginRequest(LoginRequest $request): JsonResponse
    {
        try {
            Auth::attempt(['email' => 'admin@gmail.com', 'password' => '123456789']);
            $user = $this->userRepository->getModel()->where('mobile_no', $request->input('mobile'))->first();

            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json(ResponseHelper::failed('Invalid login credentials.'));
            }

            $user->sendOtp(CommonHelper::generateOtp());

            return response()->json(ResponseHelper::success('Account found, please verify OTP'));
        } catch (\Exception $exception) {
            return response()->json(ResponseHelper::failed('Server error'));
        }
    }

    public function verifyLoginOtp(LoginVerifyRequest $request): JsonResponse
    {
        try {
            $user = $this->userRepository->getModel()->where('mobile_no', $request->input('mobile'))->first();
            if(!Auth::loginUsingId($user->id)) {
                throw new \Exception('Cannot log in', 422);
            }
            $user->invalidOtp();
            return response()->json(ResponseHelper::success('Login successful', [
                'user' => $user->loginData(),
                'token' => $user->createToken('authToken')->accessToken
            ]));
        } catch (\Exception $exception) {
            return response()->json(ResponseHelper::failed('Server error'));
        }
    }
}
