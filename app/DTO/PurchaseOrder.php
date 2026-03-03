<?php

namespace App\DTO;

use Illuminate\Support\Collection;

final readonly class PurchaseOrder
{
    public function __construct(
        public string $vendor,
        public Collection $items,
    ) {
    }

    public static function fromArray($data): PurchaseOrder
    {
        return new self(
            vendor: $data['vendor'],
            items: LineItem::collectFromArray($data['items']),
        );
    }



}