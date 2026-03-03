<?php

namespace App\Services;

use App\DTO\LineItem;
use App\DTO\PurchaseOrder;
use App\Enums\ZohoModules;

class PurchaseOrderService
{
    function __construct(private RecordService $recordService)
    {
    }


    function store(PurchaseOrder $purchaseOrder)
    {
        $data = [
            'vendor_id' => $purchaseOrder->vendor,
            'line_items' => $purchaseOrder->items->map(function (LineItem $value) {
                return [
                    'item_id' => is_array($value->details) ? $value->details['id'] : null,
                    'description' => is_array($value->details) ? ($value->details['description'] ?? null) : null,
                    'name' => !is_array($value->details) ? $value->details : null,
                    'rate' => $value->rate,
                    'quantity' => $value->quantity,
                ];
            }),


        ];
        $res = $this->recordService->create(ZohoModules::purchaseorders, $data);
        return $res['purchaseorder'];
    }
}