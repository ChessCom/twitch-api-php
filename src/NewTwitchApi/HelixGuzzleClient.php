<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;

class HelixGuzzleClient extends Client
{
    private const BASE_URI = 'https://api.twitch.tv/helix/';

    public function __construct(string $clientId = '', array $config = [])
    {
        $headers = ['Content-Type' => 'application/json'];
        if ($clientId) {
            $headers['Client-ID'] = $clientId;
        }

        $config = array_merge($config, [
            'base_uri' => self::BASE_URI,
            'timeout' => 30,
            'headers' => $headers,
        ]);

        parent::__construct($config);
    }
}
