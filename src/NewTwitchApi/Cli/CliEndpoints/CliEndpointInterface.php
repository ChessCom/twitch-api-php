<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

interface CliEndpointInterface
{
    public function getName(): string;
    public function execute(): RequestResponse;
}
