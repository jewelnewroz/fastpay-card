<?php

namespace App\Services;

use App\Gateways\GatewayInterface;
use App\Helper\ResponseHelper;
use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BundlePurchaseService
{
    private GatewayInterface $gateway;

    public function __construct(GatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function validate(BundleValidationRequest $request): JsonResponse
    {
        try {
            return $this->gateway->validate($request);
        } catch (\Exception $exception) {
            Log::error("BUNDLE_PURCHASE_VALIDATION_ERROR: " . $exception);
            return response()->json(ResponseHelper::failed('Server error!'));
        }
    }

    public function execute(BundlePurchaseExecuteRequest $request): JsonResponse
    {
        try {
            $data = $this->gateway->execute($request);
            return response()->json(ResponseHelper::success('Your purchase successful', $data));
        } catch (\Exception $exception) {
            Log::error("BUNDLE_PURCHASE_FAILED: " . $exception);
            return response()->json(ResponseHelper::failed('Server error!'));
        }
    }
}
