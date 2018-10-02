<?php

namespace TwitchApi\NewApi\CLI;

use TwitchApi\NewApi\RequestResponse;
use TwitchApi\NewApi\Users;

class GetUsersFollowsCLIEndpoint extends CLIEndpoint
{
    public function getName(): string
    {
        return 'GET USERS FOLLOWS';
    }

    public function execute(): RequestResponse
    {
        echo 'Follower ID: ';
        $followerId = $this->readIntFromStdin();
        echo 'Followed User ID: ';
        $followedUserId = $this->readIntFromStdin();
        echo 'Max results to return: ';
        $first = $this->readIntFromStdin();
        echo 'Cursor value next page starts with: ';
        $after = $this->readFromStdin();

        return (new Users($this->guzzleClient))->getUsersFollows(
            $followerId,
            $followedUserId,
            $first,
            $after
        );
    }
}
