<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

class GetAppAccessTokenCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get an App Access Token';
    }

    public function execute(): RequestResponse
    {
        $this->getOutputWriter()->write('Scope: ');
        $scope = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getOauthApi()->getAppAccessToken($scope);
    }
}
