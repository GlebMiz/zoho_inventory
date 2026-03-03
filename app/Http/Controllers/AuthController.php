<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login()
    {
        $scopes = [
            'ZohoInventory.contacts.CREATE',
            'ZohoInventory.contacts.READ',
            'ZohoInventory.items.CREATE',
            'ZohoInventory.items.READ',
            'ZohoInventory.salesorders.CREATE',
            'ZohoInventory.purchaseorders.CREATE',
            'ZohoInventory.settings.READ',
        ];

        $params = [
            'scope' => implode(',', $scopes),
            'client_id' => config('services.zoho.client_id'),
            'response_type' => 'code',
            'access_type' => 'offline',
            'redirect_uri' => config('services.zoho.redirect_uri'),
            'prompt' => 'consent',
        ];

        $login_url = config('services.zoho.domain') . '/oauth/v2/auth?' . http_build_query($params);

        return redirect($login_url);
    }

    function auth(Request $request, AuthService $authService)
    {
        $authService->authorize($request->query('code'));
        return redirect('/');

    }
}