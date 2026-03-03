<?php

namespace App\Http\Controllers;

use App\DTO\Contact;
use App\Http\Requests\CustomerRequest;
use App\Services\CustomerService;

class CustomerController
{
    function __construct()
    {
    }

    function store(CustomerRequest $request, CustomerService $customerService)
    {
        $customerDTO = Contact::fromArray($request->validated());
        $customer = $customerService->store($customerDTO);
        $customer = Contact::fromZoho($customer);
        return response()->json(['ok' => true, 'data' => $customer]);
    }

}