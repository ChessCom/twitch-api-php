<?php

declare(strict_types=1);

namespace TwitchApi\NewApi\CLI;

use Psr\Http\Message\ResponseInterface;

interface CLIEndpointInterface
{
    public function getName(): string;
    public function execute(): ResponseInterface;
}
