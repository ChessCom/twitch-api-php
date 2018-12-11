<?php

declare(strict_types=1);

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\NewTwitchApi;

abstract class AbstractCliEndpoint implements CliEndpointInterface
{
    private $twitchApi;

    public function __construct(NewTwitchApi $twitchApi)
    {
        $this->twitchApi = $twitchApi;
    }

    public function getTwitchApi(): NewTwitchApi
    {
        return $this->twitchApi;
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
