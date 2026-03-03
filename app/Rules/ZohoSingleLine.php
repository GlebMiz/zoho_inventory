<?php

namespace App\Rules;

use App\Rules\traits\UseValidatorRules;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ZohoSingleLine implements ValidationRule
{
    use UseValidatorRules;
    public function __construct(
        private int $max = 255
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->useRules($attribute, $value, $fail, [
            'string',
            "max:{$this->max}",
        ]);
    }
}