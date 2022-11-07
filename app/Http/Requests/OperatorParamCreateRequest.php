<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperatorParamCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'type' => 'required|in:text,numeric',
            'label' => 'required|string',
            'is_required' => 'required|in:1,0',
            'operator_id' => 'required|numeric|exists:operators,id',
            'placeholder' => 'nullable|string'
        ];
    }
}
