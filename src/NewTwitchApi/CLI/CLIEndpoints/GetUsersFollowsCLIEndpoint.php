<?php

namespace NewTwitchApi\CLI\CLIEndpoints;

use NewTwitchApi\RequestResponse;
use NewTwitchApi\Resources\Users;

class GetUsersFollowsCLIEndpoint extends AbstractCLIEndpoint
{
    public function getName(): string
    {
        return 'Get Users Follows';
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
