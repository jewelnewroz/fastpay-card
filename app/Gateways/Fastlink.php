<?php

namespace App\Gateways;

use App\Constants\Messages;
use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Jobs\FastLinkHandShakeJob;
use App\Models\Bundle;
use App\Models\ThirdPartyApiLog;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Fastlink implements GatewayInterface
{
    use JsonResponseTrait;

    public function __construct()
    {
        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);
    }

    public function validate(BundleValidationRequest $request): array
    {
        $data = ['status' => false, 'message' => __('You are not eligible to purchase this bundle')];
        try {
            if(!$request->has('mobile_number')) {
                throw new \Exception(__('Mobile number is required'), 422);
            }
            $msisdn = substr($request->input('mobile_number'), -9);
            $first3Digits = substr($msisdn, 0, 3);
            if (!in_array($first3Digits, ['665', '667', '668', '669'])) {
                throw new \Exception(__('Your mobile number is not valid'), 422);
            }

            if(App::environment(['production', 'staging'])) {
                $dataBundle = Bundle::find($request->bundle_id);
                $validation = $this->checkFastLinkSubscriberInformation($msisdn, $dataBundle);
                Log::debug(json_encode($validation));
                if (!$validation['status']) {
                    throw new \Exception($validation['message'], 422);
                }
                $data['status'] = $validation['status'];
            } else {
                $data['status'] = true;
                $data['message'] = 'Validation success';
            }
        } catch (\Exception $exception) {
            Log::error("Validation_exception: " . $exception);
            $data['message'] = $exception->getMessage();
        }

        return $data;
    }

    public function execute(BundlePurchaseExecuteRequest $request): bool
    {
        try {
            Log::info("in fast link");
            $dataBundle = Bundle::find($request->bundle_id);
            $msisdn = substr($request->mobile_number, -9);
            $validation = $this->checkFastLinkSubscriberInformation($msisdn, $dataBundle);
            if($validation['status']) {
                $transactionId = time() . uniqid() . substr($msisdn, -5) . 'BDT';

                $RequestIdentityType = new \stdClass();
                $RequestIdentityType->operatorId = "";
                $RequestIdentityType->deviceId = "";
                $RequestIdentityType->ipAddress = "";
                $RequestIdentityType->location = "";
                $RequestIdentityType->operatingSystem = "";

                $TransferServiceRequestType = new \stdClass();
                $TransferServiceRequestType->trx_id = $request->transaction_id;
                $TransferServiceRequestType->transactionId = $transactionId;
                $TransferServiceRequestType->requestId = $RequestIdentityType;
                $TransferServiceRequestType->MSISDN = $msisdn; // it will be dynamic, last 9 digits of users msisdn
                $TransferServiceRequestType->networkName = 'fastlink4G';
                //Top up profile
                $TransferServiceRequestType->topUpProfile = $dataBundle->activation_id;

                $thirdPartyLog = ThirdPartyApiLog::create([
                    'transaction_id' => $request->transaction_id,
                    'bundle_id' => $dataBundle->id,
                    'operator_id' => $dataBundle->operator_id,
                    'request_payload' => $TransferServiceRequestType,
                    'vendor_name' => 'FastLink',
                    'unique_uuid' => $request->inventory_call_id,
                    'caller_req' => json_encode($request->all()),
                    'caller_resp' => json_encode($this->SuccessResponse(true)->getData()),
                    'stock_order_id' => $transactionId,
                    'mobile_no' => $request->mobile_no ?? NULL
                ]);

                dispatch(new FastLinkHandShakeJob($thirdPartyLog, $TransferServiceRequestType, $transactionId, now()->addMinutes(10)));
                return true;
            }

            Log::debug("FASTLINK_VALIDATION_DEBUG_FAILED" . json_encode($validation));

            return false;
        } catch (\Exception $exception) {
            Log::error($exception);
            return false;
        }
    }


    protected function checkFastLinkSubscriberInformation($msisdn, $plan): array
    {
        $data = ['status' => false, 'message' => 'Could not validate subscriber'];
        Log::debug("Fastlink Validation CALL: (MSISDN)" . $msisdn);

        try {
//            ini_set("default_socket_timeout", 30);
            $context = stream_context_create([
                'ssl' => [
                    // set some SSL/TLS specific options
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]);
            $options = array(
                'login' => 'ee-fastpay',
                'password' => '1LF8Yk2fTSwBKDgL0cFt',
                'stream_context' => $context
            );
            $wsdl = storage_path().'/app/flsoap/subscriber/wsdl/EEMediationService.wsdl';
            $client = new \SoapClient($wsdl, $options);

            $client->__setLocation('https://eemed.my-fastlink.com:18085/eemediation-ws/EEMediationServicePort');

            $RequestIdentityType = new \stdClass();
            $RequestIdentityType->operatorId = "";
            $RequestIdentityType->deviceId = "";
            $RequestIdentityType->ipAddress = "";
            $RequestIdentityType->location = "";
            $RequestIdentityType->operatingSystem = "";

            $SubscriberInformationServiceRequestType = new \stdClass();
            $SubscriberInformationServiceRequestType->transactionId = time().uniqid().$msisdn;
            $SubscriberInformationServiceRequestType->requestId = $RequestIdentityType;
            $SubscriberInformationServiceRequestType->MSISDN = $msisdn;
            $SubscriberInformationServiceRequestType->networkName = "fastlink4G";
            $SubscriberInformationServiceRequestType->lifeCycleStatus = true;
            $SubscriberInformationServiceResponseType = new \stdClass();
            Log::debug(json_encode((array) $SubscriberInformationServiceRequestType));
            $SubscriberInformationServiceResponseType = $client->subscriberInformation($SubscriberInformationServiceRequestType);

            Log::debug("FASTLINK_VALIDATION" . json_encode((array) $SubscriberInformationServiceResponseType));

            $dynamicZone = $SubscriberInformationServiceResponseType->dynamicZone;
            $deviceType = $SubscriberInformationServiceResponseType->deviceType;
            $statusCode = $SubscriberInformationServiceResponseType->statusCode;
            Log::debug('DZ: ' . $dynamicZone . '-' . $deviceType);
            if($statusCode === 1) {
                $data['message'] = $SubscriberInformationServiceResponseType->reason;
                $data['status'] = false;
            } else {
                Log::debug('DZ: ' . $dynamicZone . '-' . $deviceType);
                $data['message'] = 'Success';
                if ($plan->device_type != null && $plan->dynamic_zones == null && in_array($deviceType, $plan->device_type)) {
                    Log::debug('Device Type & ! Zone: true' . $dynamicZone);
                    $data['status'] = true;
                } elseif ($plan->device_type != null && $plan->dynamic_zones != null && in_array($dynamicZone, $plan->dynamic_zones) && in_array($deviceType, $plan->device_type)) {
                    Log::debug('Both True: ' . $dynamicZone . '-' . $deviceType);
                    $data['status'] = true;
                } elseif(!$plan->dynamic_zones & !$plan->device_type) {
                    Log::debug('ELSE: ' . $dynamicZone . '-' . $deviceType);
                    $data['status'] = true;
                } else {
                    $data['message'] = Messages::$NOT_ELIGIBLE;
                }
            }
        } catch (\Exception $e) {
            Log::info("FASTLINK_VALIDATION_EXCEPTION: " . $e->getFile() . " " . $e->getLine(). ' '. $e->getMessage());
        }
        return $data;
    }
}
