<?php

namespace App\DTO;

use Illuminate\Support\Collection;

final readonly class Item
{
    public function __construct(
        public string|array $id,
        public string $name,
        public ?string $sku,
        public ?int $rate,
        public ?int $purchase_rate,
        public ?int $stock_on_hand,
    ) {
    }

    public static function fromZoho($data): Item
    {
        return new self(
            id: $data['item_id'],
            name: $data['name'],
            sku: $data['sku'] ?? null,
            rate: $data['rate'] ?? null,
            purchase_rate: $data['purchase_rate'] ?? null,
            stock_on_hand: $data['stock_on_hand'] ?? null,
        );
    }

    public static function collectFromZoho($arr)
    {
        $collection = new Collection();
        foreach ($arr as $val) {
            $collection->add(self::fromZoho($val));
        }
        return $collection;
    }
}