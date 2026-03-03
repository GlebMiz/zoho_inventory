<?php

namespace App\Integrations\Zoho;

use App\Exceptions\ApiException;
use App\Services\AuthService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ZohoClient
{
    public function __construct(
        private Client $http,
        private AuthService $auth,
        private ZohoErrorMapper $errors,
    ) {
    }

    public function post(string $path, array $options = []): array
    {
        return $this->request('POST', $path, $options);
    }

    public function get(string $path, array $options = []): array
    {
        return $this->request('GET', $path, $options);
    }

    private function request(string $method, string $path, array $options): array
    {
        $url = $this->baseUrl() . ltrim($path, '/');
        try {
          
            $res = $this->http->request($method, $url, array_merge([
                'headers' => [
                    'Authorization' => 'Zoho-oauthtoken ' . $this->auth->getAuthToken(),
                ],
                'timeout' => 15,
            ], $options));

            return json_decode((string) $res->getBody(), true) ?? [];

        } catch (RequestException $e) {
            $status = $e->getResponse()?->getStatusCode();

            $mapped = $this->errors->fromHttpError($status);

            throw new ApiException(
                $mapped['message'],
                $mapped['status'],
                previous: $e
            );
        }
    }

    private function baseUrl(): string
    {
        return rtrim(session('api_domain'), '/') . '/inventory/v1/';
    }
}
