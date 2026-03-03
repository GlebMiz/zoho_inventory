<?php

namespace App\Rules;

use App\Rules\traits\UseValidatorRules;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ZohoDate implements ValidationRule
{
    use UseValidatorRules;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->useRules($attribute, $value, $fail, [
            'date',
            'before_or_equal:2099-12-31',
        ]);
    }
}