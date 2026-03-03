<?php

namespace App\Services;

use App\Enums\ZohoModules;
use App\Exceptions\ApiException;
use App\Integrations\Zoho\ZohoClient;
use App\Integrations\Zoho\ZohoErrorMapper;

class RecordService
{
    function __construct(private ZohoClient $zoho, private ZohoErrorMapper $zohoErrors, )
    {

    }

    public function create(ZohoModules $module, array $data): array
    {
        $payload = [
            'json' =>$data,
        ];

        $response = $this->zoho->post($module->name, $payload);

        $this->assertCreateSuccess($response);

        return $response;
    }

    function getByModule(ZohoModules $module, array $query = [])
    {
        $query['organisation_id'] = config('services.zoho.organisation_id');
        $response = $this->zoho->get($module->name, [
            'query' => $query,
        ]);
        $this->assertListSuccess($response);

        return $response[$module->name] ?? [];
    }

    function getOneByModule(ZohoModules $module, $id, array $query = [])
    {
        $query['organisation_id'] = config('services.zoho.organisation_id');
        $response = $this->zoho->get($module->name.'/'.$id, [
            'query' => $query,
        ]);

         $this->assertListSuccess($response);

        return $response ?? [];
    }

    private function assertCreateSuccess(array $response): void
    {
        $code = $response['code'] ?? null;

        if ($code !== 0) {
            $mapped = $this->zohoErrors->fromCreateResponse($response);
            throw new ApiException($mapped['message'], $mapped['status']);
        }
    }

    private function assertListSuccess(array $response): void
    {
        if (isset($response['code']) && $response['code'] != 0) {
            $mapped = $this->zohoErrors->fromGenericError($response);
            throw new ApiException($mapped['message'], $mapped['status']);
        }
    }
}