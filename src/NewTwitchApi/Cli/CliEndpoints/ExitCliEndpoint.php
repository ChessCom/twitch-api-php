<?php

namespace NewTwitchApi\Cli\CliEndpoints;

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

    public function execute(): RequestResponse
    {
        exit;
    }
}
