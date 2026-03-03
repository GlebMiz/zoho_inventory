<?php

namespace App\Rules;

use App\Rules\traits\UseValidatorRules;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ZohoPhone implements ValidationRule
{
    use UseValidatorRules;
    public function __construct(
        private int $max = 30
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->useRules($attribute, $value, $fail, [
            'string',
            "max:{$this->max}",
            'regex:/^([+]?)(?![.-])(?>(?>[.-]?[ ]?[\da-zA-Z]+)+|([ ]?((?![.-])(?>[ .-]?[\da-zA-Z]+)+)(?![.])([ -]?[\da-zA-Z]+)?)+)+(?>(?>([,]+)?[;]?[\da-zA-Z]+)+(([#][\da-zA-Z]+)+)?)?[#;]?$/',
        ]);
    }
}