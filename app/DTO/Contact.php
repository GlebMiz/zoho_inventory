<?php

namespace App\DTO;

use Illuminate\Support\Collection;

final readonly class Contact
{
    public function __construct(
        public ?string $id,
        public string $name,
        public ?string $email,
        public ?string $phone,
        public ?string $type,
    ) {
    }

    public static function fromZoho($data)
    {
        return new self(
            id: $data['contact_id'],
            name: $data['contact_name'],
            email: $data['email'],
            phone: $data['phone'],
            type: $data['contact_type'],
        );
    }

    public static function fromArray($data)
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            type:  "customer"
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