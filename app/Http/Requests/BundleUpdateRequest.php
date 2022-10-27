<?php

namespace App\Http\Requests;

use App\Traits\FormRequestResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class BundleUpdateRequest extends FormRequest
{
    use FormRequestResponseTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'operator_id' => 'required|integer|exists:operators,id',
            'name' => 'required|string|unique:bundles,name,' . $this->bundle->id,
            'attachment' => 'nullable|mimes:jpg,jpeg,png',
            'price' => 'required|numeric',
            'top_up_profile' => 'required|string',
            'validity' => 'required|string',
            'position' => 'required|integer'
        ];
    }
}
