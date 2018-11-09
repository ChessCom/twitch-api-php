<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;
use NewTwitchApi\Resources\Users;

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

        return (new Users($this->guzzleClient))->getUsers(
            $ids,
            $usernames,
            $includeEmail === 'y'
        );
    }
}
