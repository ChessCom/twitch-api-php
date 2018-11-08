<?php

declare(strict_types=1);

namespace TwitchApi\NewApi\Auth;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Oauth
{
    private $guzzleClient;

    public function __construct(Client $guzzleClient = null)
    {
        $this->guzzleClient = $guzzleClient ?? new AuthGuzzleClient();
    }

    public function authorizeUser(string $clientId, string $redirectUri, string $scope = '', bool $forceVerify = false, string $state = null): ResponseInterface
    {
        $optionalParameters = '';
        $optionalParameters .= $forceVerify ? '&force_verify=true' : '';
        $optionalParameters .= $state ? sprintf('&state=%s', $state) : '';

        $authUrl = sprintf(
            'authorize?client_id=%s&redirect_uri=%s&response_type=token&scope=%s%s',
            $clientId,
            $redirectUri,
            $scope,
            $optionalParameters
        );

        return $this->guzzleClient->get($authUrl);
    }
}
