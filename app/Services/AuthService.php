<?php

namespace App\Services;

use App\Helper\CommonHelper;
use App\Helper\ResponseHelper;
use App\Http\Requests\API\V1\LoginRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
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
            $user = $this->userRepository->getModel()->where('mobile_no', $request->input('mobile'))->first();

            if(!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json(ResponseHelper::failed('Invalid login credentials.'));
            }

            $user->sendOtp(CommonHelper::generateOtp());

            return response()->json(ResponseHelper::success('Account found, please verify OTP'));
        } catch (\Exception $exception) {
            dd($exception);
            return response()->json(ResponseHelper::failed('Server error'));
        }
    }
}
