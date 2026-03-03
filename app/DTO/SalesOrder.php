<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Support\Collection;

final readonly class SalesOrder
{
    public function __construct(
        public string $salesOrder,
        public string $customer,
        public Carbon $date,
        public ?string $paymentTerm,
        public Collection $items,
        public ?array $adjustments,
    ) {
    }

    public static function fromArray($data)
    {
        return new self(
            salesOrder: $data['salesOrder'],
            customer: $data['customer'],
            date: Carbon::parse($data['date']),
            paymentTerm: $data['paymentTerm'] ?? null,
            items: LineItem::collectFromArray($data['items']),
            adjustments: $data['adjustments'],
        );
    }

    

}