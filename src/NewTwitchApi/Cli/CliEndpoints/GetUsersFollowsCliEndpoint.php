<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

class GetUsersFollowsCliEndpoint extends AbstractCliEndpoint
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

        return $this->getTwitchApi()->getUsersApi()->getUsersFollows(
            $followerId,
            $followedUserId,
            $first,
            $after
        );
    }
}
