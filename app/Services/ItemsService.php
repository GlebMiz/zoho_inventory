<?php

namespace App\Services;

use App\DTO\Customer;
use App\DTO\Item;
use App\DTO\LineItem;
use App\DTO\SalesOrder;
use App\Enums\ZohoModules;
use Illuminate\Support\Collection;

class ItemsService
{
    function __construct(private RecordService $recordService)
    {
    }


    function getAll()
    {
        $items = $this->recordService->getByModule(ZohoModules::items);

        $result = new Collection();
        foreach ($items as $item) {
            if($item['status'] != 'active')
                continue;

            $result->add(Item::fromZoho($item));
            
        }
        return $result;
    }
}