<?php

declare(strict_types=1);

namespace NewTwitchApi\CLI\CLIEndpoints;

use NewTwitchApi\RequestResponse;

interface CLIEndpointInterface
{
    public function getName(): string;
    public function execute(): RequestResponse;
}
