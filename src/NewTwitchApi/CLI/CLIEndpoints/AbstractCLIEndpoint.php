<?php

declare(strict_types=1);

namespace NewTwitchApi\CLI\CLIEndpoints;

use GuzzleHttp\Client;

abstract class AbstractCLIEndpoint implements CLIEndpointInterface
{
    /** @var Client */
    protected $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    protected function readFromStdin(): string
    {
        return trim(fgets(STDIN));
    }

    protected function readIntFromStdin(): int
    {
        return (int) $this->readFromStdin();
    }

    protected function readCSVIntoArrayFromStdin(): array
    {
        return array_filter(explode(',', $this->readFromStdin()));
    }
}
