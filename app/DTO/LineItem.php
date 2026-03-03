<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Support\Collection;

final readonly class LineItem
{
    public function __construct(
        public string|array $details,
        public string $quantity,
        public string $rate,
    ) {
    }

    public static function fromArray($data): LineItem
    {
        return new self(
            details: $data['details'] ?? null,
            quantity: $data['quantity'],
            rate: $data['rate'] ?? null,
        );
    }

    public static function collectFromArray($arr)
    {
        $collection = new Collection();
        foreach ($arr as $val) {
            $collection->add(self::fromArray($val));
        }
        return $collection;
    }
}