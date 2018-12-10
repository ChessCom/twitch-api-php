<?php

declare(strict_types=1);

namespace NewTwitchApi\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use NewTwitchApi\RequestResponse;
use Psr\Http\Message\ResponseInterface;

class Oauth
{
    private $clientId;
    private $guzzleClient;

    public function __construct(string $clientId, Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->guzzleClient = $guzzleClient ?? new AuthGuzzleClient();
    }

    public function getFullAuthUrl(string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): string
    {
        return $this->guzzleClient->getConfig('base_uri').$this->getAuthUrl($redirectUri, $responseType, $scope, $forceVerify, $state);
    }

    public function getAuthUrl(string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): string
    {
        $optionalParameters = '';
        $optionalParameters .= $forceVerify ? '&force_verify=true' : '';
        $optionalParameters .= $state ? sprintf('&state=%s', $state) : '';

        return sprintf(
            'authorize?client_id=%s&redirect_uri=%s&response_type=%s&scope=%s%s',
            $this->clientId,
            $redirectUri,
            $responseType,
            $scope,
            $optionalParameters
        );
    }

    public function authorizeUser(string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): ResponseInterface
    {
        return $this->guzzleClient->get(
            $this->getAuthUrl($redirectUri, $scope, $responseType, $forceVerify, $state)
        );
    }

    public function getAccessToken($code, string $clientSecret, string $redirectUri, $state = null): ResponseInterface
    {
        return $this->guzzleClient->post('token', [
            RequestOptions::JSON => [
                'client_id' => $this->clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
                'state' => $state,
            ]
        ]);
    }

    public function refreshToken(string $refeshToken, string $clientSecret, string $scope = ''): RequestResponse
    {
        $requestOptions = [
            'client_id' => $this->clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refeshToken,
        ];
        if ($scope) {
            $requestOptions['scope'] = $scope;
        }

        $request = new Request(
            'POST',
            'token'
        );

        return $this->makeRequest($request, [
            RequestOptions::JSON => $requestOptions
        ]);
    }

    public function validateAccessToken(string $accessToken): RequestResponse
    {
        $request = new Request(
            'GET',
        'validate',
            [
                'Authorization' => sprintf('OAuth %s', $accessToken)
            ]
        );

        return $this->makeRequest($request);
    }

    public function isValidAccessToken(string $accessToken): bool
    {
        return $this->validateAccessToken($accessToken)->getResponse()->getStatusCode() === 200;
    }

    private function makeRequest(Request $request, array $options = []): RequestResponse
    {
        try {
            $response = $this->guzzleClient->send($request, $options);
        } catch (GuzzleException $e) {
            return new RequestResponse($e->getRequest(), $e->getResponse());
        }

        return new RequestResponse($request, $response);
    }
}
