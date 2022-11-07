<?php

namespace App\Gateways;

use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;

class FastPayStock
{
    public function validate(BundleValidationRequest $request): array
    {

    }

    public function execute(BundlePurchaseExecuteRequest $request): bool
    {

    }
}
