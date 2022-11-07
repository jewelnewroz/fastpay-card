<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use App\Services\BundlePurchaseService;
use Illuminate\Http\JsonResponse;

class ApiBundlePurchaseController extends Controller
{
    private BundlePurchaseService $bundlePurchase;

    public function __construct(BundlePurchaseService $bundlePurchaseService)
    {
        $this->bundlePurchase = $bundlePurchaseService;
    }
    public function validation(BundleValidationRequest $request): JsonResponse
    {
        return $this->bundlePurchase->validate($request);
    }

    public function execute(BundlePurchaseExecuteRequest $request): JsonResponse
    {
        return $this->bundlePurchase->execute($request);
    }
}
