<?php

declare(strict_types=1);

namespace TwitchApi\NewApi;

class Users extends EndpointsResource
{
    public function getUserById(int $id, bool $includeEmail = false): RequestResponse
    {
        return $this->getUsers([$id], [], $includeEmail);
    }

    public function getUserByUsername(string $username, bool $includeEmail = false): RequestResponse
    {
        return $this->getUsers([], [$username], $includeEmail);
    }

    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-users Documentation for Get Users API
     */
    public function getUsers(array $ids = [], array $usernames = [], bool $includeEmail = false): RequestResponse
    {
        $queryParamsMap = [];
        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'id', 'value' => $id];
        }
        foreach ($usernames as $username) {
            $queryParamsMap[] = ['key' => 'login', 'value' => $username];
        }
        if ($includeEmail) {
            $queryParamsMap[] = ['key' => 'scope', 'value' => 'user:read:email'];
        }

        return $this->callAPI('users', $queryParamsMap);
    }

    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-users-follows Documentation for Get Users Follows API
     */
    public function getUsersFollows(int $followerId = null, int $followedUserId = null, int $first = null, string $after = null): RequestResponse
    {
        $queryParamsMap = [];
        if ($followerId) {
            $queryParamsMap[] = ['key' => 'from_id', 'value' => $followerId];
        }
        if ($followedUserId) {
            $queryParamsMap[] = ['key' => 'to_id', 'value' => $followedUserId];
        }
        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }
        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callAPI('users/follows', $queryParamsMap);
    }
}
