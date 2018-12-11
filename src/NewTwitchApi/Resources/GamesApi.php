<?php

namespace NewTwitchApi\Resources;

use NewTwitchApi\RequestResponse;

class GamesApi extends AbstractResource
{
    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-games
     */
    public function getGames(array $ids = [], array $names = []): RequestResponse
    {
        $queryParamsMap = [];
        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }
        foreach ($names as $name) {
            $queryParamsMap[] = ['key' => 'name', 'value' => $name];
        }

        return $this->callApi('games', $queryParamsMap);
    }
}
