<?php

namespace App\Gateways;

use App\Http\Lib\AesCtr;
use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Jobs\MintRouteHandShakeJob;
use App\Models\Bundle;
use App\Models\Operator;
use App\Models\ThirdPartyApiLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MintRoute implements GatewayInterface
{
    use JsonResponseTrait;
    public function validate(BundleValidationRequest $request): array
    {
        return ['status' => true, 'message' => __('Success')];
    }

    public function execute(BundlePurchaseExecuteRequest $request): bool
    {
        Log::info("in MintRoute");
        try {
            $bundle = Bundle::find($request->bundle_id);
            $operator = Operator::with("mint_route_info")->find($bundle->operator_id);
            if (empty($bundle->mint_route_info) || $bundle->mint_route_info->denomination_id == null || empty($operator->mint_route_info)) {
                throw ValidationException::withMessages(['Plan mintroute data does not exists']);
            }

            //Prepare Data
            $order_id = 'FPMR_' . uniqid();
            $payload = [
                'username' => config('mintroute.username'),
                'password' => config('mintroute.password'),
                'denomination_id' => $bundle->mint_route_info->denomination_id,
                'data' => [
                    [
                        'denomination_id' => $bundle->mint_route_info->denomination_id,
                        'brand_id' => $operator->mint_route_info->brand_id,
                        'category_id' => $operator->mint_route_info->category_id,
                        'quantity' => 1,
                        'location' => 'FastPayPos1',
                        'orderid' => $order_id,
                        'short' => true
                    ]
                ]
            ];

            $request_payload = [
                'postedinfo' => AesCtr::encrypt(json_encode($payload), config('mintroute.private_key'), 256),
                'token' => base64_encode(config('mintroute.public_key'))
            ];

            //MintRouteAPICallLog
            $thirdPartyLog = ThirdPartyApiLog::create([
                'transaction_id' => $request->transaction_id,
                'bundle_id' => $bundle->id,
                'operator_id' => $bundle->operator_id,
                'request_payload' => $payload,
                'vendor_name' => 'MintRoute',
                'unique_uuid' => $request->inventory_call_id,
                'caller_req' => json_encode($request->all()),
                'caller_resp' => json_encode($this->SuccessResponse(true)->getData()),
                'stock_order_id' => $order_id,
                'mobile_no' => $request->mobile_no ?? NULL
            ]);

            dispatch(new MintRouteHandShakeJob($thirdPartyLog, $request_payload, $bundle, $order_id, now()->addMinutes(10)));
            return true;
        } catch (\Exception $exception) {
            Log::error($exception);
            return false;
        }
    }
}
