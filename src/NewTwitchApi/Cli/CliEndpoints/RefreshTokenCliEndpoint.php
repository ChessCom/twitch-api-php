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
        $this->getOutputWriter()->write('Refresh token: ');
        $refreshToken = $this->getInputReader()->readFromStdin();
        $this->getOutputWriter()->write('Scope (comma-separated string): ');
        $scope = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getOauthApi()->refreshToken($refreshToken, $scope);
    }
}
