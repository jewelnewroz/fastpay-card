<?php

namespace App\Rules;

use App\Models\Otp;
use Illuminate\Contracts\Validation\Rule;

class ValidateOtpRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Otp::where('mobile', request()->input('mobile'))->where('otp', $value)->where('updated_at', '>=', now()->subMinutes(5))->count() === 1;
    }

    public function message(): string
    {
        return 'The :attribute is not valid or expired.';
    }
}
