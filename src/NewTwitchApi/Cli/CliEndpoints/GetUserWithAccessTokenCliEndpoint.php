<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

class GetUserWithAccessTokenCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get User with Access Token';
    }

    public function execute(): RequestResponse
    {
        $this->getOutputWriter()->write('Access Token: ');
        $accessToken = $this->getInputReader()->readFromStdin();
        $this->getOutputWriter()->write('Include email address? (y/n) ');
        $includeEmail = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getUsersApi()->getUsers(
            [],
            [],
            $includeEmail === 'y',
            $accessToken
        );
    }
}
