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
        echo 'GET USERS FOLLOWS' . PHP_EOL;
        echo 'Follower ID: ';
        $followerId = (int)trim(fgets(STDIN));
        echo 'Followee ID: ';
        $followeeId = (int)trim(fgets(STDIN));

        return (new Users($this->guzzleClient))->getUsersFollows(
            $followerId,
            $followeeId
        );
    }
}
