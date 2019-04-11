<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;

class MarketService
{
    use ConsumesExternalServices;

    /**
     * The URL to send the requests
     * @var string
     */
    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.market.base_uri');
    }

    /**
     * Resolve the elements to send when authorizing the request
     * @return void
     */
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        //
    }

    /**
     * Decode correspondingly the response
     * @return stdClass
     */
    public function decodeResponse($response)
    {
        //
    }

    /**
     * Resolve when the request failed
     * @return void
     */
    public function checkIfErrorResponse($response)
    {

    }

}
