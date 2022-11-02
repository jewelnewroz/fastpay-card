<?php

namespace App\Gateways;

use App\Http\Lib\AesCtr;
use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Jobs\EasyPayHandShakeJob;
use App\Models\Bundle;
use App\Models\Operator;
use App\Models\ThirdPartyApiLog;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EasyPay implements GatewayInterface
{
    use JsonResponseTrait;

    private string $baseUrl;
    private string $privateKey;
    private string $publicKey;
    private string $username;
    private string $password;
    private Bundle $bundle;
    private ?string $orderId = null;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {

        $this->baseUrl = config('easy_pay.base_url');
        $this->privateKey = config('easy_pay.private_key');
        $this->publicKey = config('easy_pay.public_key');
        $this->username = config('easy_pay.username');
        $this->password = config('easy_pay.password');
    }

    public function __setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    public function validate(BundleValidationRequest $request): array
    {
        $data = ['status' => false, 'message' => __('Failed')];
        $this->setBundle($request->bundle_id);
        return $this->checkAvailability($data);
    }

    public function execute(BundlePurchaseExecuteRequest $request): bool
    {
        try {
            $this->setBundle($request->bundle_id);

            //Prepare Data
            $order_id = 'EZ.' . uniqid();
            $payload = [];
            $params = $this->getParams('order');
            $request_payload = $params + ['token' => $this->getToken($params)];

            //EasyPayApiCallLog
            $thirdPartyLog = ThirdPartyApiLog::create([
                'transaction_id' => $request->transaction_id,
                'bundle_id' => $this->bundle->id,
                'operator_id' => $this->bundle->operator_id,
                'request_payload' => $request_payload,
                'vendor_name' => 'EasyPay',
                'unique_uuid' => $request->inventory_call_id,
                'caller_req' => json_encode($request->all()),
                'caller_resp' => json_encode($this->SuccessResponse(true)->getData()),
                'stock_order_id' => $order_id,
                'mobile_no' => $request->mobile_no ?? NULL
            ]);
            dispatch(new EasyPayHandShakeJob($thirdPartyLog, $request_payload, $this->bundle, now()->addMinutes(10)));
            return true;
        } catch (\Exception $exception) {
            Log::error("EASY_PAY_PURCHASE_EXCEPTION: " . $exception);
            return false;
        }
    }

    public function checkAvailability(&$data)
    {
        $params = $this->getParams('check');
        $token = $this->getToken($params);

        $client = new Client();
        $response = $client->post($this->baseUrl, [
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
            'body'    => json_encode($params + ['token' => $token])
        ]);

        $response = json_decode($response->getBody(), true);

        Log::debug('EZ_PAY_VALIDATION_RESPONSE: ' . json_encode($response));

        if($response === 1) {
            $data['message'] = __('Card available');
            $data['status'] = true;
        } else {
            $data['message'] = __('Card not available');
        }

        return $data;
    }

    private function getParams(string $method = 'check'): array
    {
        $params = [
            "publicKey" => $this->publicKey,
            "username" => $this->username,
            "password" => $this->password
        ];
        switch ($method) {
            case 'check':
                $params['type'] = 'checkAvailable';
                $params['classId'] = $this->bundle->activation_id;
                break;
            case 'order':
                $params['type'] = 'order';
                $params['classId'] = $this->bundle->activation_id;
                $params['qty'] = 1;
                break;
            case 'info':
                $params['type'] = 'getOrderInfo';
                $params['orderId'] = $this->orderId;
                break;
        }

        return $params;
    }

    private function getToken($params)
    {
        return hash('sha256', json_encode($params) . $this->privateKey);
    }

    private function setBundle($bundleId)
    {
        $this->bundle = Bundle::find($bundleId);
    }
}
