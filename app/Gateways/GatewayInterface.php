<?php

namespace App\Gateways;

use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;

interface GatewayInterface
{
    public function validate(BundleValidationRequest $request);
    public function execute(BundlePurchaseExecuteRequest $request);
}
