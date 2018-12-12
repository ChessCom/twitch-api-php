<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Cli\Exceptions\ExitCliException;
use NewTwitchApi\RequestResponse;

class ExitCliEndpoint extends AbstractCliEndpoint
{
    public function __construct()
    {
        // Don't need Guzzle client to quit
    }

    public function getName(): string
    {
        return 'Quit';
    }

    /** @throws ExitCliException */
    public function execute(): RequestResponse
    {
        throw new ExitCliException('Exit from CLI client requested.');
    }
}
