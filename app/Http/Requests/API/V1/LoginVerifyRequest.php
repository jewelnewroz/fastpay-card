<?php

namespace App\Http\Requests\API\V1;

use App\Rules\ValidateOtpRule;
use App\Rules\ValidMobile;
use App\Traits\FormJsonResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class LoginVerifyRequest extends FormRequest
{
    use FormJsonResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', new ValidMobile()],
            'otp' => ['required', 'numeric', new ValidateOtpRule()]
        ];
    }
}
