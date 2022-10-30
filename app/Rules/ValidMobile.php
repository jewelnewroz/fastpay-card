<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidMobile implements Rule
{
    public function passes($attribute, $value): bool
    {
        return preg_match('/^((\+)964)(\d{9}|\d{10})$/', $value);
    }

    public function message(): string
    {
        return 'The :attribute  should be a valid Iraqi mobile number';
    }
}
