<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use GuzzleHttp\Client;

abstract class AbstractCliEndpoint implements CliEndpointInterface
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
