<?php

declare(strict_types=1);

namespace TwitchApi\NewApi\CLI;

use TwitchApi\NewApi\RequestResponse;

interface CLIEndpointInterface
{
    public function getName(): string;
    public function execute(): RequestResponse;
}
