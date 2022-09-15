<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\RedirectResponse;

trait FormRequestResponseTrait
{
    protected function failedValidation(Validator $validator): RedirectResponse
    {
        $response = [
            'status' => false,
            'message' => $validator->errors()->first(),
        ];

        return redirect()->back()->withInput(request()->all())->with($response);
    }
}
