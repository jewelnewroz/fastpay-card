<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperatorCategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:operator_categories,name,' . $this->category->id,
            'label' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png',
            'position_number' => 'required|numeric',
            'status' => 'required|numeric|in:1,0'
        ];
    }
}
