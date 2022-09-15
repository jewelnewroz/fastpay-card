<?php

namespace App\Http\Requests;

use App\Rules\BDMobile;
use App\Traits\FormRequestResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    use FormRequestResponseTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|required|string',
            'email' => 'bail|required|email|unique:users,email,' . $this->user,
            'mobile' => ['bail', 'required', 'string', 'unique:users,mobile,' . $this->user, new BDMobile()]
        ];
    }
}
