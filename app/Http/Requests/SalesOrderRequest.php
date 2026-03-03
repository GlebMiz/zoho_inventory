<?php

namespace App\Http\Requests;

use App\Rules\ZohoDate;
use App\Rules\ZohoSingleLine;
use Illuminate\Foundation\Http\FormRequest;

class SalesOrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'salesOrder' => ['required', new ZohoSingleLine()],
            'customer' => ['required', new ZohoSingleLine()],
            'date' => ['required', new ZohoDate()],
            'items' => ['required', 'array', 'min:1'],
            'items.*.details' => ['nullable'],
            'items.*.quantity' => ['nullable'],
            'items.*.rate' => ['nullable'],
            'adjustments' => ['nullable', 'array'],
            'adjustments.0.name' => ['nullable', new ZohoSingleLine()],
            'adjustments.0.value' => ['nullable', new ZohoSingleLine()],
            'createPO' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Items is required.',

            'purchaseOrder.vendor.required_with' => 'Vendor is required.',
            'purchaseOrder.items.required_with' => 'Purchase order items are required.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $items = $this->input('items', []);

            if (is_array($items) && count($items) > 0) {
                foreach ($items as $item) {
                    if (
                        empty($item['details']) ||
                        (!isset($item['quantity']) || $item['quantity'] === '') ||
                        (!isset($item['rate']) || $item['rate'] === '')
                    ) {
                        $validator->errors()->add(
                            'items',
                            'Each item must have details, quantity and rate.'
                        );
                        break;
                    }
                }
            }

        });
    }
}