<?php

namespace TwitchApi\NewApi\CLI;

use Psr\Http\Message\ResponseInterface;
use TwitchApi\NewApi\Streams;

class GetStreamsCLIEndpoint extends CLIEndpoint
{
    public function getName(): string
    {
        return 'GET STREAMS';
    }

    public function execute(): ResponseInterface
    {
        echo 'User ID: ';
        $userId = $this->readIntFromStdin();

        return (new Streams($this->guzzleClient))->getStreamForUserId(
            $userId
        );
    }
}
