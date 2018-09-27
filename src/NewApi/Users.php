<?php

declare(strict_types=1);

namespace TwitchApi\NewApi;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Users
{
    private $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

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
}
