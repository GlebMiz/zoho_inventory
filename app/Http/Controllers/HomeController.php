<?php

namespace App\Http\Controllers;

use App\DTO\PurchaseOrder;
use App\DTO\SalesOrder;
use App\Http\Requests\SalesOrderRequest;
use App\Services\CustomerService;
use App\Services\ItemsService;
use App\Services\PurchaseOrderService;
use App\Services\SalesOrderService;
use Inertia\Inertia;

class HomeController
{
    function __construct()
    {
    }

    function index(CustomerService $customerService, ItemsService $itemsService)
    {
        [$customers, $vendors] = $customerService->getAll();

        $items = $itemsService->getAll();
        return Inertia::render('Main', ['customers' => $customers, 'items' => $items, 'vendors' => $vendors]);
    }

    function store(SalesOrderRequest $request, SalesOrderService $salesOrderService)
    {
        $salesOrderDTO = SalesOrder::fromArray($request->except('createPO'));

        if ($request->input('createPO')) {
            $salesOrderService->createPO($salesOrderDTO);
        }

        $salesOrderService->store($salesOrderDTO);

        return response()->json(['ok' => true]);
    }

}