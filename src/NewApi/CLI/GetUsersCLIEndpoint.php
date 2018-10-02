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
        $ids = trim(fgets(STDIN));
        echo 'Usernames (separated by commas): ';
        $usernames = trim(fgets(STDIN));
        echo 'Include email address? (y/n) ';
        $includeEmail = trim(fgets(STDIN));

        return (new Users($this->guzzleClient))->getUsers(
            array_filter(explode(',', $ids)),
            array_filter(explode(',', $usernames)),
            $includeEmail === 'y'
        );
    }
}
