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
            //
        ];
    }
}
