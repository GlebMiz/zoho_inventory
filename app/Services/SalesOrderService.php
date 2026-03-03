<?php

namespace App\Services;

use App\DTO\Customer;
use App\DTO\LineItem;
use App\DTO\SalesOrder;
use App\Enums\ZohoModules;

class SalesOrderService
{
    function __construct(private RecordService $recordService)
    {
    }


    function store(SalesOrder $salesOrder)
    {
        $data = [
            'customer_id' => $salesOrder->customer,
            'salesorder_number' => $salesOrder->salesOrder,
            'date' => $salesOrder->date->format('Y-m-d'),
            'terms' => $salesOrder->paymentTerm,
            'line_items' => $salesOrder->items->map(function (LineItem $value) {
                return [
                    'item_id' => is_array($value->details) ? $value->details['id'] : null,
                    'description' => is_array($value->details) ? ($value->details['description'] ?? null) : null,
                    'name' => !is_array($value->details) ? $value->details : null,
                    'rate' => $value->rate,
                    'quantity' => $value->quantity,
                ];
            }),
            'adjustment_decription' => $salesOrder->adjustments[0]['name'] ?? null,
            'adjustment' => $salesOrder->adjustments[0]['value'] ?? null,

        ];
        $res = $this->recordService->create(ZohoModules::salesorders, $data);
        return $res['salesorder'];
    }
}