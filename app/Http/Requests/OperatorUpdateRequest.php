<?php

namespace App\Http\Requests;

use App\Traits\FormRequestResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class OperatorUpdateRequest extends FormRequest
{
    use FormRequestResponseTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'attachment' => 'required|file|mimes:jpg,jpeg,png',
            'category' => 'required|string',
            'gateway' => 'required|exists:gateways,name',
            'position' => 'required|integer',
            'status' => 'required|integer|in:1,0'
        ];
    }
}
