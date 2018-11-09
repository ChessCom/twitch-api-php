<?php

declare(strict_types=1);

namespace NewTwitchApi\Auth;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Oauth
{
    private $guzzleClient;

    public function __construct(Client $guzzleClient = null)
    {
        $this->guzzleClient = $guzzleClient ?? new AuthGuzzleClient();
    }

    public function getFullAuthUrl(string $clientId, string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): string
    {
        return $this->guzzleClient->getConfig('base_uri').$this->getAuthUrl($clientId, $redirectUri, $responseType, $scope, $forceVerify, $state);
    }

    public function getAuthUrl(string $clientId, string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): string
    {
        $optionalParameters = '';
        $optionalParameters .= $forceVerify ? '&force_verify=true' : '';
        $optionalParameters .= $state ? sprintf('&state=%s', $state) : '';

        return sprintf(
            'authorize?client_id=%s&redirect_uri=%s&response_type=%s&scope=%s%s',
            $clientId,
            $redirectUri,
            $responseType,
            $scope,
            $optionalParameters
        );
    }

    public function authorizeUser(string $clientId, string $redirectUri, string $responseType = 'code', string $scope = '', bool $forceVerify = false, string $state = null): ResponseInterface
    {
        return $this->guzzleClient->get(
            $this->getAuthUrl($clientId, $redirectUri, $scope, $responseType, $forceVerify, $state)
        );
    }

    public function getAccessToken($code, string $clientId, string $clientSecret, string $redirectUri, $state = null): ResponseInterface
    {
        return $this->guzzleClient->post('token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri,
            'code' => $code,
            'state' => $state,
        ]);
    }
}
