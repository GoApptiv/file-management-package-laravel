<?php

namespace GoApptiv\FileManagement\Traits;

use GuzzleHttp\Client;
use GoApptiv\FileManagement\Models\Request;

trait RestCall
{
    /**
     * Send a request to any external service
     * 
     * @return mixed
     */
    public function makeRequest(Request $request) {
        $client = new Client([]);
        $response = $client->request($request->getMethod(), $request->getEndPoint(), [
            'headers' => $request->getHeaders(),
            'query' => $request->getQueryParams(),
            'json' => $request->getPayload(),
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
    }

    /**
     * Build Request
     * 
     * @param $method
     * @param $endPoint
     * @param array $data
     * @param array $headers
     * @param array $queryParams 
     * @return Request
     */
    public function buildRequest($method, $data, $endPoint, $headers, $queryParams) {
        $request = new Request();
        $request->setMethod($method);
        $request->setEndPoint($endPoint);
        $request->setPayload($data);
        $request->setHeaders($headers);
        $request->setQueryParams($queryParams);
        
        return $request;
    }
}