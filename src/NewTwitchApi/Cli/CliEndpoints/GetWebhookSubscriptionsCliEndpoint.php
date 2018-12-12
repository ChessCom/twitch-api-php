<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

class GetWebhookSubscriptionsCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get Webhook Subscriptions for User';
    }

    public function execute(): RequestResponse
    {
        $this->getOutputWriter()->write('Access Token: ');
        $accessToken = $this->getInputReader()->readFromStdin();
        $this->getOutputWriter()->write('Limit number of values returned to: ');
        $first = $this->getInputReader()->readIntFromStdin();
        $this->getOutputWriter()->write('Cursor for forward pagination: ');
        $after = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getWebhooksApi()->getWebhookSubscriptions(
            $accessToken,
            $first,
            $after
        );
    }
}
