<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

class ValidateTokenCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Validate an Access Token';
    }

    public function execute(): RequestResponse
    {
        $this->getOutputWriter()->write('Access token: ');
        $accessToken = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getOauthApi()->validateAccessToken($accessToken);
    }
}
