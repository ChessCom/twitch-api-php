<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\Cli\Exceptions\ExitCliException;
use Psr\Http\Message\ResponseInterface;

interface CliEndpointInterface
{
    public function getName(): string;
    /** @throws ExitCliException */
    public function execute(): ResponseInterface;
}
