<?php

use GuzzleHttp\Client;
use TwitchApi\NewApi\HelixGuzzleClient;
use TwitchApi\NewApi\Users;

require __DIR__ . '/../vendor/autoload.php';

echo 'Twitch API Testing Tool'.PHP_EOL.PHP_EOL;

if (!isset($argv[1])) {
    echo sprintf('Usage: php %s <client-id>', $argv[0]);
    exit(1);
}
$guzzleClient = new HelixGuzzleClient($argv[1]);

while (true) {
    echo PHP_EOL;
    echo 'Which endpoint would you like to call?'.PHP_EOL;
    echo '1) GET USERS'.PHP_EOL;
    echo '2) GET USERS FOLLOWS'.PHP_EOL;
    echo 'Choice: ';
    $choice = fgets(STDIN);
    switch ($choice) {
        case 1:
            getUsers($guzzleClient);
            break;
        case 2:
            getUsersFollows($guzzleClient);
            break;
    }
}

function getUsers(Client $guzzleClient)
{
    echo 'GET USERS'.PHP_EOL;
    echo 'IDs (separated by commas): ';
    $ids = trim(fgets(STDIN));
    echo 'Usernames (separated by commas): ';
    $usernames = trim(fgets(STDIN));
    echo 'Include email address? (y/n) ';
    $includeEmail = trim(fgets(STDIN));

    $usersApi = new Users($guzzleClient);
    $response = $usersApi->getUsers(
        array_filter(explode(',', $ids)),
        array_filter(explode(',', $usernames)),
        $includeEmail === 'y'
    );

    var_dump(json_decode((string) $response->getBody()));
}

function getUsersFollows(Client $guzzleClient)
{
    echo 'GET USERS FOLLOWS'.PHP_EOL;
    echo 'Follower ID: ';
    $followerId = (int) trim(fgets(STDIN));
    echo 'Followee ID: ';
    $followeeId = (int) trim(fgets(STDIN));

    $usersApi = new Users($guzzleClient);
    $response = $usersApi->getUsersFollows(
        $followerId,
        $followeeId
    );

    var_dump(json_decode((string) $response->getBody()));
}

