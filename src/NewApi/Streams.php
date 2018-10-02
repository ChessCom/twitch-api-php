<?php

declare(strict_types=1);

namespace TwitchApi\NewApi;

use Psr\Http\Message\ResponseInterface;

class Streams extends EndpointsResource
{
    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-streams Documentation for Get Streams API
     */
    public function getStreamForUserId(int $userId): ResponseInterface
    {
        return $this->guzzleClient->get(sprintf('streams?user_id=%d', $userId));
    }
}
