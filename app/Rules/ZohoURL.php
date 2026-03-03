<?php

namespace App\Rules;

use App\Rules\traits\UseValidatorRules;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ZohoURL implements ValidationRule
{
    use UseValidatorRules;
    public function __construct(
        private int $max = 30
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^(http:\/\/www\.|https:\/\/www\.|ftp:\/\/www\.|www\.|http:\/\/|https:\/\/|ftp:\/\/|){1}[^\x00-\x19\x22-\x27\x2A-\x2C\x2E-\x2F\x3A-\x3F\x5B-\x5E\x60\x7B\x7D-\x7F]+(\.[^\x00-\x19\x22\x24-\x2C\x2E-\x2F\x3C\x3E\x40\x5B-\x5E\x60\x7B\x7D-\x7F]+)+([\/\?].*)*$/';

        $this->useRules($attribute, $value, $fail, [
            'string',
            "max:{$this->max}",
            "regex:$pattern",
        ]);
    }
}