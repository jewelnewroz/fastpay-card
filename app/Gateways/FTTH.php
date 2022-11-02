<?php

namespace App\Gateways;

use App\Constants\AppConstant;
use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Jobs\FtthHandShakeJob;
use App\Models\Bundle;
use App\Models\ThirdPartyApiLog;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FTTH implements GatewayInterface
{
    use JsonResponseTrait;

    private string $base_url = 'http://api.o3-telecom.com/';
    private array $headers = [
        'Accept' => 'application/json',
    ];

    public function __construct()
    {
        $this->headers['authorization'] = 'Token ' . config('basic_settings.third-party.ftth.token');
    }

    public function validate(BundleValidationRequest $request): array
    {
        $data = ['status' => false, 'message' => __('Success')];
        try {
            $bundle = Bundle::find($request->bundle_id);

            $request_payload = [
                'userId' => $request->input('mobile_number'),
                'offerId' => $bundle->activation_id
            ];

            $client = new Client(['base_uri' => $this->base_url]);

            $response = $client->get('api/v2/get_client_name', [
                'debug' => FALSE,
                'query' => $request_payload,
                'headers' => $this->headers
            ]);

            Log::debug('Validation Call: ' . $response->getBody());
            $body = json_decode($response->getBody(), true);

            if ((isset($body['status']) && $body['status'] == "success")) {
                $data['status'] = true;
            } else {
                $data['message'] = $body['message'] ?? __('You are not eligible to this bundle');
            }

            Log::info("Validation" . json_encode($body));
        } catch (\Exception $exception) {
            Log::error($exception);
            $data['message'] = __('Something went wrong');
        }
        return $data;
    }

    public function execute(BundlePurchaseExecuteRequest $request): bool
    {
        try {
            Log::info("in FTTH");
            $transactionId = uniqid() . $request->input('mobile_number');
            $bundle = Bundle::find($request->bundle_id);

            $thirdPartyLog = ThirdPartyApiLog::create([
                'transaction_id' => $request->transaction_id,
                'bundle_id' => $bundle->id,
                'operator_id' => $bundle->operator_id,
                'caller_req' => json_encode($request->all()),
                'caller_resp' => json_encode($this->SuccessResponse(true)->getData()),
                'request_payload' => [
                    'userId' => $request->input('mobile_number'),
                    'offerId' => $bundle->activation_id,
                    'transactionId' => $transactionId,
                ],
                'vendor_name' => 'FTTH',
                'unique_uuid' => $request->inventory_call_id,
                'stock_order_id' => $transactionId,
                'mobile_no' => $request->mobile_no ?? NULL
            ]);

            dispatch(new FtthHandShakeJob($thirdPartyLog, $transactionId, now()->addMinutes(AppConstant::JOB_EXPIRE_MINUTES)));

            return true;
        } catch (\Exception $exception) {
            Log::error($exception);
            return false;
        }
    }
}
