<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use NewTwitchApi\RequestResponse;

class Streams extends AbstractResource
{
    public function getStreamForUserId(int $userId): RequestResponse
    {
        return $this->getStreams([$userId]);
    }

    public function getStreamForUsername(string $username): RequestResponse
    {
        return $this->getStreams([], [$username]);
    }

    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-streams Documentation for Get Streams API
     */
    public function getStreams(array $userIds = [], array $usernames = [], array $gameIds = [], array $communityIds = [], array $languages = [], string $first = null, string $before = null, string $after = null): RequestResponse
    {
        $queryParamsMap = [];
        foreach ($userIds as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }
        foreach ($usernames as $username) {
            $queryParamsMap[] = ['key' => 'user_login', 'value' => $username];
        }
        foreach ($gameIds as $gameId) {
            $queryParamsMap[] = ['key' => 'game_id', 'value' => $gameId];
        }
        foreach ($communityIds as $communityId) {
            $queryParamsMap[] = ['key' => 'community_id', 'value' => $communityId];
        }
        foreach ($languages as $language) {
            $queryParamsMap[] = ['key' => 'language', 'value' => $language];
        }
        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }
        if ($before) {
            $queryParamsMap[] = ['key' => 'before', 'value' => $before];
        }
        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callAPI('streams', $queryParamsMap);
    }
}
