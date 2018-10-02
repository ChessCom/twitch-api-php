<?php

namespace TwitchApi\NewApi\CLI;

use Psr\Http\Message\ResponseInterface;
use TwitchApi\NewApi\Users;

class GetUsersCLIEndpoint extends CLIEndpoint
{
    public function getName(): string
    {
        return 'GET USERS';
    }

    public function execute(): ResponseInterface
    {
        echo 'IDs (separated by commas): ';
        $ids = $this->readFromStdin();
        echo 'Usernames (separated by commas): ';
        $usernames = $this->readFromStdin();
        echo 'Include email address? (y/n) ';
        $includeEmail = $this->readFromStdin();

        return (new Users($this->guzzleClient))->getUsers(
            array_filter(explode(',', $ids)),
            array_filter(explode(',', $usernames)),
            $includeEmail === 'y'
        );
    }
}
