<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

class RefreshTokenCliEndpoint extends AbstractCliEndpoint
{
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

        return $this->getTwitchApi()->getOauthApi()->refreshToken($refreshToken, $scope);
    }
}
