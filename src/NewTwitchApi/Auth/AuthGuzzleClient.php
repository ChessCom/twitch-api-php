<?php

declare(strict_types=1);

namespace NewTwitchApi\Auth;

use GuzzleHttp\Client;

class AuthGuzzleClient extends Client
{
    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'base_uri' => 'https://id.twitch.tv/oauth2/',
        ]);

        parent::__construct($config);
    }
}
