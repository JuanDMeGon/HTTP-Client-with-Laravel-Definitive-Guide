<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumesExternalServices
{
    /**
     * Send a request to any service
     * @return sdtClass|string
     */
    public function makeRequest($method, $requestUrl, $queryParams = [], $formParams = [], $headers = [], $hasFile = false)
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        if (method_exists($this, 'resolveAuthorization')) {
            $this->resolveAuthorization($queryParams, $formParams, $headers);
        }

        $bodyType = 'form_params';

        if ($hasFile) {
            $bodyType = 'multipart';

            $multipart = [];

            foreach ($formParams as $name => $contents) {
                $multipart[] = ['name' => $name, 'contents' => $contents];
            }
        }

        $response = $client->request($method, $requestUrl, [
            'query' => $queryParams,
            $bodyType => $hasFile ? $multipart : $formParams,
            'headers' => $headers,
        ]);

        $response = $response->getBody()->getContents();

        if (method_exists($this, 'decodeResponse')) {
            $response = $this->decodeResponse($response);
        }

        if (method_exists($this, 'checkIfErrorResponse')) {
            $this->checkIfErrorResponse($response);
        }

        return $response;
    }
}
