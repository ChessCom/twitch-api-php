<?php

declare(strict_types=1);

namespace TwitchApi\NewApi\CLI;

use GuzzleHttp\Client;

abstract class CLIEndpoint implements CLIEndpointInterface
{
    /** @var Client */
    protected $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }
}
