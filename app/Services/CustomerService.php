<?php

namespace App\Services;

use App\DTO\Contact;
use App\Enums\ZohoModules;

class CustomerService
{
    function __construct(private RecordService $recordService)
    {
    }

    function getAll()
    {
        $contacts = $this->recordService->getByModule(ZohoModules::contacts);
        $customers = [];
        $vendors = [];
        foreach ($contacts as $contact) {
            if ($contact['status'] != 'active')
                continue;
            if ($contact['contact_type'] == 'customer') {
                $customers[] = Contact::fromZoho($contact);
            } else if ($contact['contact_type'] == 'vendor') {
                $vendors[] = Contact::fromZoho($contact);
            }
        }
        return [$customers, $vendors];
    }

    function store(Contact $customer)
    {
        $data = [
            'contact_name' => $customer->name,
            'contact_persons' => [
                [
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ]
            ],
        ];
        $res = $this->recordService->create(ZohoModules::contacts, $data);
        return $res['contact'];
    }
}