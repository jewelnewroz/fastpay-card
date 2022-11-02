<?php

namespace App\Gateways;

use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;

class NotExist implements GatewayInterface
{
    public function validate(BundleValidationRequest $request): array
    {
        return ['status' => true, 'message' => __('Success')];
    }

    public function execute(BundlePurchaseExecuteRequest $request)
    {
        //
    }
}
