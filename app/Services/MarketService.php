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
        $accessToken = $this->resolveAccessToken();

        $headers['Authorization'] = $accessToken;
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

    /**
     * Resolve a valid access token to use
     * @return string
     */
    public function resolveAccessTOken()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijc3MzRmNGU0ZjAyMzU5ZGUxOTMwYzE4YjdiOTAzMmJmNWJjNmUxNDMzYjRiZmE3YWY1M2FlOGJjY2YzN2E2NmQzY2VhNDMwZGNhYjRlMjk0In0.eyJhdWQiOiIyIiwianRpIjoiNzczNGY0ZTRmMDIzNTlkZTE5MzBjMThiN2I5MDMyYmY1YmM2ZTE0MzNiNGJmYTdhZjUzYWU4YmNjZjM3YTY2ZDNjZWE0MzBkY2FiNGUyOTQiLCJpYXQiOjE1NTUwMDk3NjQsIm5iZiI6MTU1NTAwOTc2NCwiZXhwIjoxNTg2NjMyMTY0LCJzdWIiOiIxMDA2Iiwic2NvcGVzIjpbInB1cmNoYXNlLXByb2R1Y3QiLCJtYW5hZ2UtcHJvZHVjdHMiLCJtYW5hZ2UtYWNjb3VudCIsInJlYWQtZ2VuZXJhbCJdfQ.NMVtuRvkOt0NWSVbDwlgLGxIRVSHiqteClFWzLaRAv5_s6dPcEVU6UK7QG0ekDLYjOXijBcDNWFfHrp9EC1rojvPEs12dgKtmvVhG4wAr_M5CVbF5fxjAwu1sWqttxGRbIcSylYMqX9cRCqoe_5GbZPLsfWTGtXBs0Y9DJ6WGMuuqguKURrIhVINS557Z_hgt-bPw62WNs0sVbpnR2fWjdalAUt73_6Dy-fGXovKi92bEDg2TYCjCYSehFgB6FzoWmG87oDHQCTmCdfpp4hB0Kc-F4m5Z_BVTf-LI1KQLaSjxD7ersiwtzUTGvRkWviv4o3Zhu8JT1If1Q7RP-MJBM9RKJG993pbN38eLNJ6KWvX6oSbWQxpv26JiJPu1pPe2RjJxmKEANvPUFBD11UN2dAhByj1t14cyWWOyoIjNNv1PvI3Y7eBm-Jw-B2BK_DehoSK0c0uIvjxRKINAqyb61fUO7I3PYYy7LfwRB6sJM-o9Y_Gtp5RKm9WmBsqHB7LmoFHodny8kqqpg7cn1dLhPuCDnmFxN9E4zG7Ko6FeQA5hTvli-Q4uho-iZY93J4_rMF6uiadzVvb7Ghdsed0GokAmXJ-n9Fid_zc5wCnNs6aFcWDrLqojym3q3SuhO0KxFR4Gdz52gfS3-XrebShdJmsWpGy_olGmo40InEekug';
    }

}
