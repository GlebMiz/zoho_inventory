<?php

namespace App\Rules\traits;

use Illuminate\Support\Facades\Validator;

trait UseValidatorRules
{
    protected function useRules($attribute, $value, $fail, $rules)
    {
        $validator = Validator::make(
            [$attribute => $value],
            [
                $attribute => $rules
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $fail($message);
            }
        }
    }
}