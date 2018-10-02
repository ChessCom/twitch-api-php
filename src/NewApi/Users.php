<?php

declare(strict_types=1);

namespace TwitchApi\NewApi;

use Psr\Http\Message\ResponseInterface;

class Users extends EndpointsResource
{
    /**
     * Convenience method for getting a single user with their Twitch ID
     * @see getUsers
     */
    public function getUserById(int $id, bool $includeEmail = false): ResponseInterface
    {
        return $this->getUsers([$id], [], $includeEmail);
    }

    /**
     * Convenience method for getting a single user with their Twitch username
     * @see getUsers
     */
    public function getUserByUsername(string $username, bool $includeEmail = false): ResponseInterface
    {
        return $this->getUsers([], [$username], $includeEmail);
    }

    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-users Documentation for Get Users API
     */
    public function getUsers(array $ids = [], array $usernames = [], bool $includeEmail = false): ResponseInterface
    {
        $queryStringParams = '';
        foreach ($ids as $id) {
            $queryStringParams .= sprintf('&id=%d', $id);
        }
        foreach ($usernames as $username) {
            $queryStringParams .= sprintf('&login=%s', $username);
        }
        if ($includeEmail) {
            $queryStringParams .= '&scope=user:read:email';
        }
        $queryStringParams = $queryStringParams ? '?'.substr($queryStringParams, 1) : '';

        return $this->guzzleClient->get(sprintf('users%s', $queryStringParams));
    }

    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-users-follows Documentation for Get Users Follows API
     */
    public function getUsersFollows(int $followerId = null, int $followeeId = null): ResponseInterface
    {
        $queryStringParams = '';
        if ($followerId) {
            $queryStringParams .= sprintf('&from_id=%d', $followerId);
        }
        if ($followeeId) {
            $queryStringParams .= sprintf('&to_id=%d', $followeeId);
        }
        $queryStringParams = $queryStringParams ? '?'.substr($queryStringParams, 1) : '';

        return $this->guzzleClient->get(sprintf('users/follows%s', $queryStringParams));
    }
}
