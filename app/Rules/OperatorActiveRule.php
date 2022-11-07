<?php

namespace App\Rules;

use App\Constants\AppConstant;
use App\Models\Bundle;

use Illuminate\Contracts\Validation\Rule;

class OperatorActiveRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return (Bundle::whereHas('operator', function($query) {
                $query->where('status', AppConstant::OPERATOR_ACTIVE);
            })->has('operator')->where('status', 1)->find($value) !== null);
    }

    public function message(): string
    {
        return __('Your selected operator is not active');
    }
}
