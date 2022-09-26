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
            'name' => 'required|string|unique:operators,name',
            'title' => 'required|string',
            'store' => 'required|numeric',
            'logo' => 'required|file|mimes:jpg,jpeg,png',
            'pos_logo' => 'required|file|mimes:jpg,jpeg,png',
            'user_types' => 'required|array'
        ];
    }
}
