<?php

declare(strict_types=1);

namespace TwitchApi\NewApi;

use GuzzleHttp\Client;

abstract class EndpointsResource
{
    protected $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }
}
