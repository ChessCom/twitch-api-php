<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use NewTwitchApi\RequestResponse;

abstract class AbstractResource
{
    protected $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    protected function callApi(string $uriEndpoint, array $queryParamsMap = [], string $bearer = null): RequestResponse
    {
        $request = new Request(
            'GET',
            sprintf('%s%s', $uriEndpoint, $this->generateQueryParams($queryParamsMap)),
            $bearer ? ['Authorization' => sprintf('Bearer %s', $bearer)] : []
        );
        try {
            $response = $this->guzzleClient->send($request);
        } catch (GuzzleException $e) {
            return new RequestResponse($e->getRequest(), $e->getResponse());
        }

        return new RequestResponse($request, $response);
    }

    /**
     * $queryParamsMap should be a mapping of the param key expected in the API call URL,
     * and the value to be sent for that key.
     *
     * [['key' => 'param_key', 'value' => 42],['key' => 'other_key', 'value' => 'asdf']]
     * would result in
     * ?param_key=42&other_key=asdf
     */
    protected function generateQueryParams(array $queryParamsMap): string
    {
        $queryStringParams = '';
        foreach ($queryParamsMap as $paramMap) {
            if ($paramMap['value']) {
                $format = is_int($paramMap['value']) ? '%d' : '%s';
                $queryStringParams .= sprintf('&%s='.$format, $paramMap['key'], $paramMap['value']);
            }
        }

        return $queryStringParams ? '?'.substr($queryStringParams, 1) : '';
    }
}