<?php

namespace App\Services;

use App\DTO\Customer;
use App\DTO\Item;
use App\DTO\LineItem;
use App\DTO\SalesOrder;
use App\Enums\ZohoModules;
use Illuminate\Support\Collection;

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

    function createPO(SalesOrder $salesOrder)
    {
        $purchaseOrders = [];

        foreach ($salesOrder->items as $lineItem) {
            if (is_array($lineItem->details)) {
                $res = $this->recordService->getOneByModule(ZohoModules::items, $lineItem->details['id']);
                $item = $res['item'];

                if ($item['vendor_id'] && $item['purchase_rate']) {
                    $diff = $lineItem->quantity - $item['actual_available_stock'];
                    if ($diff <= 0)
                        continue;

                    $purchaseOrders[$item['vendor_id']][] = [
                        'item_id' => $item['item_id'],
                        'rate' => $item['purchase_rate'],
                        'quantity' => $diff,
                    ];
                }
            }
        }

        if (count($purchaseOrders) > 0) {
            foreach ($purchaseOrders as $vendor_id => $poItems) {
                $data = [
                    'vendor_id' => $vendor_id,
                    'line_items' => $poItems,
                ];
                $this->recordService->create(ZohoModules::purchaseorders, $data);
            }
        }

    }
}