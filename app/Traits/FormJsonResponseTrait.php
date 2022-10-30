<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;

trait FormJsonResponseTrait
{
    protected function failedValidation(Validator $validator) {
        $response = [
            'success' => false,
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors()
        ];
        throw new HttpResponseException(response()->json($response, 200));
    }
}
