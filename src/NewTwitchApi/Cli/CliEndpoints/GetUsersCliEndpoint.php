<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

class GetUsersCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get Users';
    }

    public function execute(): RequestResponse
    {
        echo 'IDs (separated by commas): ';
        $ids = $this->readCSVIntoArrayFromStdin();
        echo 'Usernames (separated by commas): ';
        $usernames = $this->readCSVIntoArrayFromStdin();
        echo 'Include email address? (y/n) ';
        $includeEmail = $this->readFromStdin();

        return $this->getTwitchApi()->getUsersApi()->getUsers(
            $ids,
            $usernames,
            $includeEmail === 'y'
        );
    }
}
