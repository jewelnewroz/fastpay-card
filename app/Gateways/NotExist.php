<?php

namespace App\Gateways;

use App\Helper\ResponseHelper;
use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use Illuminate\Http\JsonResponse;

class NotExist implements GatewayInterface
{
    public function validate(BundleValidationRequest $request): JsonResponse
    {
        return response()->json(ResponseHelper::failed('Gateway not exists'));
    }

    public function execute(BundlePurchaseExecuteRequest $request): JsonResponse
    {
        return response()->json(ResponseHelper::failed('Gateway not exists'));
    }
}
