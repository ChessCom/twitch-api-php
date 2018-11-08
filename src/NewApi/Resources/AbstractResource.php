<?php

declare(strict_types=1);

namespace TwitchApi\NewApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use TwitchApi\NewApi\RequestResponse;

abstract class AbstractResource
{
    protected $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    protected function callAPI(string $uriEndpoint, array $queryParamsMap = []): RequestResponse
    {
        $request = new Request('GET', sprintf('%s%s', $uriEndpoint, $this->generateQueryParams($queryParamsMap)));
        $response = $this->guzzleClient->send($request);

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
