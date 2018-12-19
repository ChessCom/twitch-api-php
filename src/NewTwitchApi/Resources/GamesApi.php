<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use Psr\Http\Message\ResponseInterface;

class GamesApi extends AbstractResource
{
    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-games
     */
    public function getGames(array $ids = [], array $names = []): ResponseInterface
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
