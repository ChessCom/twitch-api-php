<?php

namespace TwitchApi\NewApi\CLI;

use TwitchApi\NewApi\RequestResponse;
use TwitchApi\NewApi\Users;

class GetUsersCLIEndpoint extends CLIEndpoint
{
    public function getName(): string
    {
        return 'GET USERS';
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
