<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AuthService
{
    function authorize($code)
    {
        $token_url = config('services.zoho.domain') . '/oauth/v2/token';
        $client = new Client();
        $response = $client->post($token_url, [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('services.zoho.client_id'),
                'client_secret' => config('services.zoho.client_secret'),
                'code' => $code,
                'redirect_uri' => config('services.zoho.redirect_uri'),
            ]
        ]);

        $response = json_decode($response->getBody(), true);
        if (isset($response['access_token']) && isset($response['refresh_token'])) {
            session(key: [
                'refresh_token' => $response['refresh_token'],
                'access_token' => $response['access_token'],
                'api_domain' => $response['api_domain'],
                'access_token_exired_at' => now()->addMinutes(10),
            ]);
        }
    }

    function getAuthToken()
    {
        $access_token = session('access_token');
        $access_token_expired_at = session('access_token_exired_at');

        return !$access_token || $access_token_expired_at->isPast() ? $this->refreshAuthToken() : $access_token;
    }

    private function refreshAuthToken()
    {
        try {
            $client = new Client();
            $response = $client->post(config('services.zoho.domain') . '/oauth/v2/token', [
                'form_params' => [
                    'refresh_token' => session('refresh_token'),
                    'client_id' => config('services.zoho.client_id'),
                    'client_secret' => config('services.zoho.client_secret'),
                    'grant_type' => 'refresh_token',
                ],
            ]);

            $response = json_decode($response->getBody(), true);
            if (isset($response['access_token'])) {
                session([
                    'access_token' => $response['access_token'],
                    'access_token_exired_at' => now()->addMinutes(10),
                ]);
                return $response['access_token'];
            }
        } catch (Exception $e) {
            Log::error($e);
        }

        return null;
    }


}