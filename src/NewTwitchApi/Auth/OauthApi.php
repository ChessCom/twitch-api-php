<?php

declare(strict_types=1);

namespace NewTwitchApi\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use NewTwitchApi\RequestResponse;

class OauthApi
{
    private $clientId;
    private $clientSecret;
    private $guzzleClient;

    public function __construct(string $clientId, string $clientSecret, Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->guzzleClient = $guzzleClient ?? new AuthGuzzleClient();
    }

    /**
     * @return string A full authentication URL, including the Guzzle client's base URI.
     */
    public function getFullAuthUrl(string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): string
    {
        return sprintf(
            '%s%s',
            $this->guzzleClient->getConfig('base_uri'),
            $this->getAuthUrl($redirectUri, $responseType, $scope, $forceVerify, $state)
        );
    }

    /**
     * @return string A partial authentication URL, excluding the Guzzle client's base URI.
     */
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

    public function authorizeUser(string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): RequestResponse
    {
        $request = new Request(
            'GET',
            $this->getAuthUrl($redirectUri, $responseType, $scope, $forceVerify, $state)
        );

        return $this->makeRequest($request);
    }

    public function getUserAccessToken($code, string $redirectUri, $state = null): RequestResponse
    {
        return $this->makeRequest(
            new Request('POST', 'token'),
            [
                RequestOptions::JSON => [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirectUri,
                    'code' => $code,
                    'state' => $state,
                ]
            ]
        );
    }

    public function refreshToken(string $refeshToken, string $scope = ''): RequestResponse
    {
        $requestOptions = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refeshToken,
        ];
        if ($scope) {
            $requestOptions['scope'] = $scope;
        }

        return $this->makeRequest(
            new Request('POST', 'token'),
            [
                RequestOptions::JSON => $requestOptions
            ]
        );
    }

    public function validateAccessToken(string $accessToken): RequestResponse
    {
        return $this->makeRequest(
            new Request(
                'GET',
                'validate',
                [
                    'Authorization' => sprintf('OAuth %s', $accessToken)
                ]
            )
        );
    }

    public function isValidAccessToken(string $accessToken): bool
    {
        return $this->validateAccessToken($accessToken)->getResponse()->getStatusCode() === 200;
    }

    public function getAppAccessToken(string $scope = ''): RequestResponse
    {
        return $this->makeRequest(
            new Request('POST', 'token'),
            [
                RequestOptions::JSON => [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => 'client_credentials',
                    'scope' => $scope,
                ]
            ]
        );
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
