<?php

namespace App\Rules;

use App\Models\BundleAttribute;
use Illuminate\Contracts\Validation\Rule;

class UniqueAttributeRule implements Rule
{
    private $attributes;
    private $attribute;

    public function __construct($attributes, $attribute = null)
    {
        $this->attributes = $attributes;
        $this->attribute = $attribute;
    }

    public function passes($attribute, $value): bool
    {
        $attribute = BundleAttribute::where('bundle_id', '=', $this->attributes['bundle_id'])->where('label', '=', $value)->where('language', '=', $this->attributes['language']);
        if($this->attribute != null) {
            $attribute->where('id', '!=', $this->attribute);
        }

        return $attribute->count() === 0;
    }

    public function message(): string
    {
        return 'The Label is already exist with same language';
    }
}
