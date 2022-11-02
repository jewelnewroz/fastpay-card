<?php

namespace App\Gateways;

use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Jobs\MintRouteDirectHandShakeJob;
use App\Models\Bundle;
use App\Models\ThirdPartyApiLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MintRouteDirect implements GatewayInterface
{
    use JsonResponseTrait;

    private string $public_key;
    public array $data;
    private string $private_key;
    private string $baseUrl;
    private string $tzDateString;

    public function __construct()
    {
        $this->baseUrl = config('mintroute.direct.base_url');
        $this->public_key = config('mintroute.direct.public_key');
        $this->private_key = config('mintroute.direct.private_key');
        $this->data['username'] = config('mintroute.direct.username');
        $this->data['password'] = config('mintroute.direct.password');
        $this->tzDateString = xMintDate();
    }

    public function setData($key, $value): MintRouteDirect
    {
        $this->data[$key] = $value;
        return $this;
    }

    private function getHeader(): array
    {
        return [
            'Accept' => "application/json",
            'Content-Type' => "application/json",
            'Authorization' => 'algorithm="hmac-sha256",credential="' . $this->public_key . '/' . date('Ymd') . '",signature="' . mintRouteDirectSignature(getStringToSign($this->data)) . '"',
            'X-Mint-Date' => $this->tzDateString
        ];
    }

    public function validate(BundleValidationRequest $request): array
    {
        $data = ['status' => false, 'message' => __('Validation failed')];
        try {
            $bundle = Bundle::find($request->bundle_id);
            $this->data['data'] = ['denomination_id' => (int)$bundle->activation_id, 'account_id' => $request->account_id];

            if($request->filled('zone_id')) {
                $this->data['data']['zone_id'] = $request->zone_id;
            }

            if ($this->verify()) {
                $data = ['status' => true, 'message' => __('Success')];
            }
        } catch (\Exception $exception) {
            Log::error("MINT_ROUTE_DIRECT_TOPUP_VALIDATION_EXCEPTION: " . $exception);
        }
        Log::info('MINT_ROUTE_DIRECT' . json_encode($data));
        return $data;
    }

    public function execute(BundlePurchaseExecuteRequest $request): bool
    {
        try {
            $bundle = Bundle::find($request->bundle_id);
            if ($bundle->activation_id == null) {
                throw ValidationException::withMessages(['Plan denomination ID not set'], 422);
            }

            //Prepare Data
            $order_id = 'FPDR_' . uniqid();
            $this->data['data'] = [
                'denomination_id' => (int)$bundle->activation_id,
                'account_id' => $request->account_id
            ];

            if($request->filled('zone_id')) {
                $this->data['data']['zone_id'] = $request->zone_id;
            }

            //MintRouteAPICallLog
            $thirdPartyLog = ThirdPartyApiLog::create([
                'transaction_id' => $request->transaction_id,
                'bundle_id' => $bundle->id,
                'operator_id' => $bundle->operator_id,
                'request_payload' => $this->data,
                'vendor_name' => 'MintRoute',
                'unique_uuid' => $request->inventory_call_id,
                'caller_req' => json_encode($request->all()),
                'caller_resp' => json_encode($this->SuccessResponse(true)->getData()),
                'stock_order_id' => $order_id,
                'mobile_no' => $request->mobile_no ?? NULL
            ]);

            dispatch(new MintRouteDirectHandShakeJob($thirdPartyLog, $this->getHeader(), $order_id));
            return true;
        } catch (\Exception $exception) {
            Log::error('MINT_ROUTE_DIRECT_EXECUTE_EXCEPTION: ' . $exception);
            return false;
        }
    }

    private function verify(): bool
    {
        try {
            Log::info("M_DIRECT_REQUEST_DATA" . json_encode($this->data));
            $client = new Client();
            $response = $client->request('POST', $this->baseUrl . 'account_validation', [
                'headers' => $this->getHeader(),
                'json' => $this->data
            ]);

            $body = json_decode($response->getBody(), true);
            return is_array($body) && $body['status'] === true;
        } catch (\Exception|GuzzleException $exception) {
            Log::error('MINT_ROUTE_VALIDATION_EXCEPTION: ' . $exception);
            return false;
        }
    }

}
