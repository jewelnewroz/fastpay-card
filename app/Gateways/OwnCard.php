<?php

namespace App\Gateways;

use App\Constants\AppConstant;
use App\Helper\ResponseHelper;
use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use App\Jobs\BundlePurchaseIpnJob;
use App\Models\Bundle;
use App\Models\Card;
use App\Models\ThirdPartyApiLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OwnCard implements GatewayInterface
{
    public function validate(BundleValidationRequest $request): array
    {
        try {
            $count = Card::where('status', 0)->where('bundle_id', $request->input('bundle_id'))->count();
            if($count <= 2) {
                throw new \Exception('Stock not available', 404);
            }
            return request()->json(ResponseHelper::success());
        } catch (\Exception $exception) {
            return request()->json(ResponseHelper::failed('Stock not available'));
        }
    }

    public function execute(BundlePurchaseExecuteRequest $request): bool
    {
        Log::debug($request->all());
        Log::info("in Own Card");
        try {
            $orderId = Str::uuid() . 'OWN';
            $bundle = Bundle::find($request->bundle_id);
            $card = Card::where('status', 0)->where('bundle_id', $request->bundle_id)->inRandomOrder()->lockForUpdate()->first();

            $thirdPartyLog = ThirdPartyApiLog::create([
                'transaction_id' => $request->transaction_id,
                'bundle_id' => $bundle->id,
                'operator_id' => $bundle->operator_id,
                'vendor_name' => 'Card',
                'request_payload' => $request->all(),
                'api_response_status' => 500,
                'unique_uuid' => $request->inventory_call_id,
                'caller_req' => json_encode($request->all()),
                'caller_resp' => json_encode($this->SuccessResponse(true)->getData()),
                'stock_order_id' => $orderId,
                'mobile_no' => $request->mobile_no ?? NULL
            ]);

            if ($card === null) {
                throw new \Exception('Stock unavailable', 422);
            }

            $status = AppConstant::FAILED;
            $cardId = null;

            $response_payload = ['status' => 'failed', 'transaction_id' => $request->transaction_id, 'stock_order_id' => $orderId];
            if ($card !== null && $card->update(['status' => 1, 'mobile_no' => $thirdPartyLog->mobile_no, 'transaction_id' => $request->transaction_id])) {
                $cardId = $card->id;
                $status = AppConstant::SUCCESS;
                $response_payload['status'] = AppConstant::SUCCESS;
                $thirdPartyLog->update(['card_id' => $card->id, 'response_payload' => $response_payload, 'api_response_status' => 200]);
            }

            $thirdPartyLog->update(['response_payload' => $response_payload]);
            Log::debug('Response Payload: ' . json_encode($response_payload));
            dispatch(new BundlePurchaseIpnJob($request->transaction_id, $response_payload, $status, $orderId, $thirdPartyLog, $cardId));
            return true;
        } catch (\Exception $exception) {
            Log::error("OWN_CARD_EXCEPTION: " . $exception);
            return false;
        }
    }
}
