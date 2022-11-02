<?php

namespace App\Gateways;

use App\Constants\AppConstant;
use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Jobs\GanjanCityHandShakeJob;
use App\Models\Bundle;
use App\Models\ThirdPartyApiLog;
use Illuminate\Support\Facades\Log;

class GanjanCity implements GatewayInterface
{
    use JsonResponseTrait;

    private string $baseUrl;
    public function validate(BundleValidationRequest $request): array
    {
        return [
            'status' => true
        ];
    }

    public function execute(BundlePurchaseExecuteRequest $request)
    {
        try {
            Log::info("in GANJAN_CITY");
            $inventoryCallID = uniqid('ganjan.');
            $bundle = Bundle::find($request->bundle_id);

            $thirdPartyLog = ThirdPartyApiLog::create([
                'transaction_id' => $request->input('transaction_id'),
                'bundle_id' => $bundle->id,
                'operator_id' => $bundle->operator_id,
                'caller_req' => json_encode($request->all()),
                'caller_resp' => json_encode($this->SuccessResponse(true)->getData()),
                'request_payload' => [
                    'transaction_id' => $request->input('transaction_id'),
                    'amount' => $bundle->activation_id,
                    'inventory_call_id' => $inventoryCallID,
                    'mobile_number' => $request->input('mobile_no')
                ],
                'vendor_name' => 'FTTH',
                'unique_uuid' => $request->inventory_call_id,
                'stock_order_id' => $inventoryCallID,
                'mobile_no' => $request->mobile_no ?? NULL
            ]);

            dispatch(new GanjanCityHandShakeJob($thirdPartyLog, $bundle, now()->addMinutes(AppConstant::JOB_EXPIRE_MINUTES)));

            return true;
        } catch (\Exception $exception)
        {
            Log::error("GANJAN_CITY_FAILED_EXCEPTION " . $exception);
        }
    }
}
