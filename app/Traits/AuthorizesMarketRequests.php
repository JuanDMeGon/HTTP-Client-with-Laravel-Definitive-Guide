<?php

namespace App\Traits;

use App\Services\MarketAuthenticationService;

trait AuthorizesMarketRequests
{
    /**
     * Resolve the elements to send when authorizing the request
     * @return void
     */
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();

        $headers['Authorization'] = $accessToken;
    }

    /**
     * Resolve a valid access token to use
     * @return string
     */
    public function resolveAccessToken()
    {
        $authenticationService = resolve(MarketAuthenticationService::class);

        if (auth()->user()) {
            return $authenticationService->getAuthenticatedUserToken();
        }

        return $authenticationService->getClientCredentialsToken();
    }
}
