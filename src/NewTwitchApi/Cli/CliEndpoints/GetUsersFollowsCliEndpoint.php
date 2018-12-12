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
        $this->getOutputWriter()->write('Follower ID: ');
        $followerId = $this->getInputReader()->readIntFromStdin();
        $this->getOutputWriter()->write('Followed User ID: ');
        $followedUserId = $this->getInputReader()->readIntFromStdin();
        $this->getOutputWriter()->write('Max results to return: ');
        $first = $this->getInputReader()->readIntFromStdin();
        $this->getOutputWriter()->write('Cursor value next page starts with: ');
        $after = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getUsersApi()->getUsersFollows(
            $followerId,
            $followedUserId,
            $first,
            $after
        );
    }
}
