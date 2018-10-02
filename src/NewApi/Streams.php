<?php

declare(strict_types=1);

namespace TwitchApi\NewApi;

class Streams extends EndpointsResource
{
    /**
     * Convenience method for getting a single user's stream info with their Twitch ID
     * @see getStreams
     */
    public function getStreamForUserId(int $userId): RequestResponse
    {
        return $this->getStreams([$userId]);
    }

    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-streams Documentation for Get Streams API
     */
    public function getStreams(array $userIds = null, array $usernames = null, array $gameIds = null, array $communityIds = null, array $languages = null, string $first = null, string $before = null, string $after = null): RequestResponse
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
