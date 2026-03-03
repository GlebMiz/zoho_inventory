<?php

namespace App\Services;

use App\Enums\ZohoModules;
use App\Integrations\Zoho\ZohoClient;
use App\Integrations\Zoho\ZohoErrorMapper;

class FieldsService
{
    function __construct(private ZohoClient $zoho, private ZohoErrorMapper $zohoErrors, )
    {

    }

    function getValues(ZohoModules $module, string $fieldName)
    {
        $response = $this->zoho->get('settings/fields', ['query' => ['module' => $module->name]]);
        $fields = $response['fields'] ?? [];

        $stageField = collect($fields)
            ->firstWhere('api_name', $fieldName);

        if (!$stageField) {
            throw new \Exception('Stage field not found');
        }

        return collect($stageField['pick_list_values'] ?? [])
            ->pluck('display_value')
            ->values()
            ->toArray();
    }
}