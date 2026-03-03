<?php

namespace App\Http\Requests;

use App\Rules\ZohoPhone;
use App\Rules\ZohoSingleLine;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', new ZohoSingleLine()],
            'email' => ['nullable', 'email', new ZohoSingleLine()],
            'phone' => ['nullable', new ZohoPhone()],
        ];
    }
}