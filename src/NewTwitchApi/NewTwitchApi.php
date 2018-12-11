<?php

declare(strict_types=1);

namespace NewTwitchApi;

use GuzzleHttp\Client;
use NewTwitchApi\Auth\OauthApi;
use NewTwitchApi\Resources\GamesApi;
use NewTwitchApi\Resources\StreamsApi;
use NewTwitchApi\Resources\UsersApi;

class NewTwitchApi
{
    private $oauthApi;
    private $gamesApi;
    private $streamsApi;
    private $usersApi;

    public function __construct(Client $helixGuzzleClient, string $clientId, string $clientSecret)
    {
        $this->oauthApi = new OauthApi($clientId, $clientSecret);
        $this->gamesApi = new GamesApi($helixGuzzleClient);
        $this->streamsApi = new StreamsApi($helixGuzzleClient);
        $this->usersApi = new UsersApi($helixGuzzleClient);
    }

    public function getOauthApi(): OauthApi
    {
        return $this->oauthApi;
    }

    public function getGamesApi(): GamesApi
    {
        return $this->gamesApi;
    }

    public function getStreamsApi(): StreamsApi
    {
        return $this->streamsApi;
    }

    public function getUsersApi(): UsersApi
    {
        return $this->usersApi;
    }
}
