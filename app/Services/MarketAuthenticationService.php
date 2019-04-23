<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;
use App\Traits\InteractsWithMarketResponses;

class MarketAuthenticationService
{
    use ConsumesExternalServices, InteractsWithMarketResponses;

    /**
     * The URL to send the requests
     * @var string
     */
    protected $baseUri;

    /**
     * The client id to identify the client in ther API
     * @var string
     */
    protected $clientId;

    /**
     * The client secret to identify the client in ther API
     * @var string
     */
    protected $clientSecret;

    /**
     * The client id to identify the password client in ther API
     * @var string
     */
    protected $passwordClientId;

    /**
     * The client secret to identify the password client in ther API
     * @var string
     */
    protected $passwordClientSecret;

    public function __construct()
    {
        $this->baseUri = config('services.market.base_uri');
        $this->clientId = config('services.market.client_id');
        $this->clientSecret = config('services.market.client_secret');
        $this->passwordClientId = config('services.market.password_client_id');
        $this->passwordClientSecret = config('services.market.password_client_secret');
    }

    /**
     * Obtains an access token associated with the client
     * @return stdClass
     */
    public function getClientCredentialsToken()
    {
        if ($token = $this->existingValidToken())  {
            return $token;
        }

        $formParams = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'client_credentials');

        return $tokenData->access_token;
    }

    /**
     * Generate the URL to obtain users authorization
     * @return string
     */
    public function resolveAuthorizationUrl()
    {
        $query = http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => route('authorization'),
            'response_type' => 'code',
            'scope' => 'purchase-product manage-products manage-account read-general',
        ]);

        return "{$this->baseUri}/oauth/authorize?{$query}";
    }

    /**
     * Obtains an access token from a given code
     * @return stdClass
     */
    public function getCodeToken($code)
    {
        $formParams = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => route('authorization'),
            'code' => $code,
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'authorization_code');

        return $tokenData;
    }

    /**
     * Obtains an access token the user credentials
     * @return stdClass
     */
    public function getPasswordToken($username, $password)
    {
        $formParams = [
            'grant_type' => 'password',
            'client_id' => $this->passwordClientId,
            'client_secret' => $this->passwordClientSecret,
            'username' => $username,
            'password' => $password,
            'scope' => 'purchase-product manage-products manage-account read-general',
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'password');

        return $tokenData;
    }

    /**
     * Obtains an access token from the current user
     * @return string
     */
    public function getAuthenticatedUserToken()
    {
        $user = auth()->user();

        if (now()->lt($user->token_expires_at)) {
            return $user->access_token;
        }

        return $this->refreshAuthenticatedUserToken($user);

    }

    /**
     * Refresh a valid token from a User
     * @return string
     */
    public function refreshAuthenticatedUserToken($user)
    {
        $clientId = $this->clientId;
        $clientSecret = $this->clientSecret;

        if ($user->grant_type === 'password') {
            $clientId = $this->passwordClientId;
            $clientSecret = $this->passwordClientSecret;
        }

        $formParams = [
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $user->refresh_token,
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, $user->grant_type);

        $user->fill([
            'access_token' => $tokenData->access_token,
            'refresh_token' => $tokenData->refresh_token,
            'token_expires_at' => $tokenData->token_expires_at,
        ]);

        $user->save();

        return $tokenData->access_token;
    }

    /**
     * Stores a valid token with some attributes
     * @return void
     */
    public function storeValidToken($tokenData, $grantType)
    {
        $tokenData->token_expires_at = now()->addSeconds($tokenData->expires_in - 5);
        $tokenData->access_token = "{$tokenData->token_type} {$tokenData->access_token}";
        $tokenData->grant_type = $grantType;

        session()->put(['current_token' => $tokenData]);
    }

    /**
     * Verify if there is any valid token on session
     * @return string\boolean
     */
    public function existingValidToken()
    {
        if (session()->has('current_token')) {
            $tokenData = session()->get('current_token');

            if (now()->lt($tokenData->token_expires_at)) {
                return $tokenData->access_token;
            }
        }

        return false;
    }
}
