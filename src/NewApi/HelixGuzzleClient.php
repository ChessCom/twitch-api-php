<?php

declare(strict_types=1);

namespace TwitchApi\NewApi;

use GuzzleHttp\Client;

class HelixGuzzleClient extends Client
{
    public function __construct(string $clientId = '', array $config = [])
    {
        $headers = ['Content-Type' => 'application/json'];
        if ($clientId) {
            $headers['Client-ID'] = $clientId;
        }

        $config = array_merge($config, [
            'base_uri' => 'https://api.twitch.tv/helix/',
            'timeout' => 30,
            'headers' => $headers,
        ]);

        parent::__construct($config);
    }
}
