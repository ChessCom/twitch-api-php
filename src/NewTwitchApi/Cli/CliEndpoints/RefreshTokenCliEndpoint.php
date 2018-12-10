<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use GuzzleHttp\Client;
use NewTwitchApi\Auth\AuthGuzzleClient;
use NewTwitchApi\Auth\Oauth;
use NewTwitchApi\RequestResponse;

class RefreshTokenCliEndpoint extends AbstractCliEndpoint
{
    private $clientId;
    private $clientSecret;

    public function __construct(string $clientId, string $clientSecret = '', Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        parent::__construct($guzzleClient ?? new AuthGuzzleClient());
    }

    public function getName(): string
    {
        return 'Refresh an Access Token';
    }

    public function execute(): RequestResponse
    {
        echo 'Refresh token: ';
        $refreshToken = $this->readFromStdin();
        echo 'Scope (comma-separated string): ';
        $scope = $this->readFromStdin();

        return (new Oauth($this->clientId))->refreshToken($refreshToken, $this->clientSecret, $scope);
    }
}
