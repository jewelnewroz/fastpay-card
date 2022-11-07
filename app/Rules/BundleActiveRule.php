<?php

namespace App\Rules;

use App\Models\Bundle;
use Illuminate\Contracts\Validation\Rule;

class BundleActiveRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return (Bundle::where('status', 1)->find($value) !== null);
    }

    public function message(): string
    {
        return __('Your selected bundle is not active');
    }
}
