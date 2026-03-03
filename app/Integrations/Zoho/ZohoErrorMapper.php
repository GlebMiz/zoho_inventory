<?php

namespace App\Integrations\Zoho;

class ZohoErrorMapper
{
    public function fromCreateResponse(array $response): array
    {
        $row = $response['data'][0] ?? null;

        if (!$row) {
            return [
                'message' => 'Zoho returned unexpected response',
                'status' => 502,
            ];
        }

        $message = $row['message'] ?? 'Zoho error';

        return [
            'message' => $message,
            'status' => 422,
        ];
    }

    public function fromHttpError(?int $status): array
    {
        if (in_array($status, [401, 403], true)) {
            return ['message' => 'Zoho authorization failed. If the problem persists, please try re-logging in.', 'status' => 401];
        }

        if ($status === 429) {
            return ['message' => 'Zoho rate limit exceeded', 'status' => 429];
        }

        if ($status && $status >= 400 && $status < 500) {
            return ['message' => 'Zoho request failed', 'status' => 422];
        }

        return ['message' => 'Zoho is temporarily unavailable', 'status' => 503];
    }

    public function fromGenericError(array $response): array
    {
        return [
            'message' => $response['message'] ?? 'Zoho error',
            'status' => 422,
        ];
    }


}