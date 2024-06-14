<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use League\OAuth2\Client\Provider\Google;
class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        $provider = new Google([
            'clientId' => env('MAIL_CLIENT_ID'),
            'clientSecret' => env('MAIL_CLIENT_SECRET'),
            'redirectUri' => route('auth.google.callback'), // Your callback route
        ]);

        // Request specific scopes for email sending
        $options = [
            'access_type' => 'offline', // Request a refresh token
            'prompt' => 'consent'       // Force approval prompt to get refresh token
        ];

        return $provider->getAuthorizationUrl($options);
    }

    public function handleGoogleCallback(Request $request)
    {
        $provider = new Google([
            'clientId' => env('MAIL_CLIENT_ID'),
            'clientSecret' => env('MAIL_CLIENT_SECRET'),
            'redirectUri' => route('auth.google.callback'),
        ]);

        if ($request->has('error')) {
            // Handle authorization errors...
            return redirect('/login')->with('error', 'Google authentication failed.');
        }

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $request->input('code'),
        ]);
dd($token);
        // Store the refresh token
        $refreshToken = $token->getRefreshToken();
        // Store this refresh token securely (e.g., in the database or encrypted in .env)

        // Now you can use the $token to interact with the Gmail API
        $client = new \Google_Client();
        $client->setAccessToken($token->getToken());

        $service = new \Google_Service_Gmail($client);
        $user = $service->users->getProfile('me')->execute();
        // ... rest of your logic to find or create the user and log them in ...
    }
}
