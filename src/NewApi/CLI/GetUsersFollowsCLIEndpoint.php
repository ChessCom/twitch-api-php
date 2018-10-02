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
        echo 'First entry for pagination: ';
        $first = $this->readIntFromStdin();
        echo 'Start pagination after cursor value: ';
        $after = $this->readFromStdin();

        return (new Users($this->guzzleClient))->getUsersFollows(
            $followerId,
            $followeeId,
            $first,
            $after
        );
    }
}
