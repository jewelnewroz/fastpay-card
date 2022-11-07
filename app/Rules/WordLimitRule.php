<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WordLimitRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return wordCount($value) > 100 === false;
    }

    public function message(): string
    {
        return 'The :attribute cannot be more than 100 words';
    }
}
