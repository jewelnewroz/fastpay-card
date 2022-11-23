<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FormValidationResponseTrait
{
    protected function failedValidation(Validator $validator) {
        $response = [
            'code' => 422,
            'message' => array_values($validator->errors()->all()),
        ];
        throw new HttpResponseException(response()->json($response, 422));
    }
}
