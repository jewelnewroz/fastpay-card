<?php

namespace App\Gateways;

use App\Http\Requests\BundlePurchaseExecuteRequest;
use App\Http\Requests\BundleValidationRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Jobs\NewRozHandShakeJob;
use App\Models\Bundle;
use App\Models\ThirdPartyApiLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Newroz implements GatewayInterface
{
    use JsonResponseTrait;

    public function __construct()
    {
        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);
    }

    public function validate(BundleValidationRequest $request): array
    {
        $data = ['status' => false, 'message' => __('Success')];
        try {
            $validation = Validator::make($request->all(), [
                'mobile_number' => 'required'
            ]);
            if ($validation->fails()) {
                throw new \Exception(__('Mobile number is required'), 422);
            }

            $msisdn = substr($request->input('mobile_number'), -9);
            $first3Digits = substr($msisdn, 0, 3);
            if (!in_array($first3Digits, ['662', '663', '627', '664'])) {
                throw new \Exception(__('Your mobile number is not valid'), 422);
            }
            $dataBundle = Bundle::find($request->bundle_id);
            $validation = $this->checkNewrozSubscriberInformation($msisdn, $dataBundle);
            if(!$validation['status']) {
                throw new \Exception($validation['message'], 422);
            }
            $data['status'] = $validation['status'];
        } catch (\Exception $exception) {
            Log::error($exception);
            $data['message'] = $exception->getMessage();
        }

        return $data;
    }

    public function execute(BundlePurchaseExecuteRequest $request)
    {
        try {
            $msisdn = substr($request->input('mobile_number'), -9);
            $transactionId = time().uniqid().substr($msisdn, -5).'BDT';
            $dataBundle = Bundle::find($request->bundle_id);
            Log::info("in newroz");

            $validation = $this->checkNewrozSubscriberInformation($msisdn, $dataBundle);
            if($validation['status']) {

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
                $TransferServiceRequestType->networkName = 'newroz4G';

                $thirdPartyLog = ThirdPartyApiLog::create([
                    'transaction_id' => $request->transaction_id,
                    'bundle_id' => $dataBundle->id,
                    'operator_id' => $dataBundle->operator_id,
                    'request_payload' => $TransferServiceRequestType,
                    'vendor_name' => 'Newroz',
                    'unique_uuid' => $request->inventory_call_id,
                    'caller_req' => json_encode($request->all()),
                    'caller_resp' => json_encode($this->SuccessResponse(true)->getData()),
                    'stock_order_id' => $transactionId,
                    'mobile_no' => $request->mobile_no ?? NULL
                ]);

                dispatch(new NewRozHandShakeJob($thirdPartyLog, $dataBundle, $transactionId, $TransferServiceRequestType, now()->addMinutes(10)));
                return true;
            } else {
                return false;
            }
        } catch (\SoapFault $fault) {
            Log::error($fault);
            if(isset($thirdPartyLog)){
                $thirdPartyLog->update(['response_payload' => (array)$fault->faultstring, 'api_response_status' => 500]);
            }
            return false;
        } catch (\Exception $exception) {
            Log::error($exception);
            return false;
        }
    }

    protected function checkNewrozSubscriberInformation($msisdn, $plan): array
    {
        $data = ['status' => false, 'message' => 'Could not validate subscriber'];
        Log::debug("Validation CALL: " . $msisdn);
        try {
//            ini_set("default_socket_timeout", 5);
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
            $SubscriberInformationServiceResponseType = $client->subscriberInformation($SubscriberInformationServiceRequestType);

            Log::error(json_encode((array)$SubscriberInformationServiceResponseType));
            $statusCode = $SubscriberInformationServiceResponseType->statusCode;
            if($statusCode === 1) {
                $data['message'] = $SubscriberInformationServiceResponseType->reason;
                $data['status'] = false;
            } else {
                $data['status'] = true;
            }

        }  catch (ValidationException $e) {
            Log::error($e);
        } catch (\Exception $e) {
            Log::info($e->getFile() . " " . $e->getLine(). ' '. $e->getMessage());
        }

        return $data;

    }
}
