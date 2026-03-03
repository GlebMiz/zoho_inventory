<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ZohoIsValidField implements ValidationRule
{

    function __construct(private array $values){
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value)
            return;

        if(!in_array($value, $this->values))
            $fail("The $attribute value does not exist");

    }
}