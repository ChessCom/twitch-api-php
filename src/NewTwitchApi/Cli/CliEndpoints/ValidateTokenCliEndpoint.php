<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use GuzzleHttp\Client;
use NewTwitchApi\Auth\AuthGuzzleClient;
use NewTwitchApi\Auth\Oauth;
use NewTwitchApi\RequestResponse;

class ValidateTokenCliEndpoint extends AbstractCliEndpoint
{
    private $clientId;

    public function __construct(string $clientId, Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        parent::__construct($guzzleClient ?? new AuthGuzzleClient());
    }

    public function getName(): string
    {
        return 'Validate an Access Token';
    }

    public function execute(): RequestResponse
    {
        echo 'Access token: ';
        $accessToken = $this->readFromStdin();

        return (new Oauth($this->clientId))->validateAccessToken($accessToken);
    }
}
