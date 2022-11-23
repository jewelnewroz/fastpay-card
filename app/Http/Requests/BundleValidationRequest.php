<?php

namespace App\Http\Requests;

use App\Http\Traits\FormValidationResponseTrait;
use App\Rules\BundleActiveRule;
use App\Rules\OperatorActiveRule;
use Illuminate\Foundation\Http\FormRequest;

class BundleValidationRequest extends FormRequest
{
    use FormValidationResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'bundle_id' => ['bail', 'required', 'integer', 'exists:bundles,id', new BundleActiveRule(), new OperatorActiveRule()],
            'mobile_number' => 'nullable'
        ];
    }
}
