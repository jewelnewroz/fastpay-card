<?php

namespace App\Http\Requests\Api;

use App\Http\Traits\FormValidationResponseTrait;
use App\Rules\BundleActiveRule;
use App\Rules\OperatorActiveRule;
use Illuminate\Foundation\Http\FormRequest;

class BundlePurchaseExecuteRequest extends FormRequest
{
    use FormValidationResponseTrait;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bundle_id' => ['bail', 'required', 'integer', 'exists:bundles,id', new BundleActiveRule(), new OperatorActiveRule()]
        ];
    }
}
