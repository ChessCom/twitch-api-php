<?php

namespace TwitchApi\NewApi\CLI;

use Psr\Http\Message\ResponseInterface;
use TwitchApi\NewApi\Users;

class GetUsersFollowsCLIEndpoint extends CLIEndpoint
{
    public function getName(): string
    {
        return 'GET USERS FOLLOWS';
    }

    public function execute(): ResponseInterface
    {
        echo 'Follower ID: ';
        $followerId = $this->readIntFromStdin();
        echo 'Followee ID: ';
        $followeeId = $this->readIntFromStdin();

        return (new Users($this->guzzleClient))->getUsersFollows(
            $followerId,
            $followeeId
        );
    }
}
