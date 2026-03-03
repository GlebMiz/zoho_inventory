<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ZohoIsValidChild implements ValidationRule
{
    protected $values;
    function __construct(array $childs)
    {
        $this->values = $childs ? collect($childs)->pluck('id')->toArray() : [];
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value)
            return;

        if(!in_array($value, $this->values))
            $fail("The $attribute value does not exist");
    }
}