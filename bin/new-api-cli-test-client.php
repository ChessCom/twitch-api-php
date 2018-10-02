<?php

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use TwitchApi\NewApi\HelixGuzzleClient;
use TwitchApi\NewApi\Users;

require __DIR__ . '/../vendor/autoload.php';

echo 'Twitch API Testing Tool'.PHP_EOL.PHP_EOL;

if (!isset($argv[1])) {
    echo sprintf('Usage: php %s <client-id>', $argv[0]);
    exit(1);
}
$guzzleClient = new HelixGuzzleClient($argv[1]);

/** @var ResponseInterface $response */
$response = null;
while (true) {
    echo PHP_EOL;
    echo 'Which endpoint would you like to call?'.PHP_EOL;
    echo '0) Exit'.PHP_EOL;
    echo '1) GET USERS'.PHP_EOL;
    echo '2) GET USERS FOLLOWS'.PHP_EOL;
    echo 'Choice: ';
    $choice = fgets(STDIN);
    switch ($choice) {
        case 0:
            exit();
        case 1:
            $response = getUsers($guzzleClient);
            break;
        case 2:
            $response = getUsersFollows($guzzleClient);
            break;
    }
    echo PHP_EOL.json_encode(json_decode($response->getBody()), JSON_PRETTY_PRINT).PHP_EOL;
}

function getUsers(Client $guzzleClient): ResponseInterface
{
    echo 'GET USERS'.PHP_EOL;
    echo 'IDs (separated by commas): ';
    $ids = trim(fgets(STDIN));
    echo 'Usernames (separated by commas): ';
    $usernames = trim(fgets(STDIN));
    echo 'Include email address? (y/n) ';
    $includeEmail = trim(fgets(STDIN));

    return (new Users($guzzleClient))->getUsers(
        array_filter(explode(',', $ids)),
        array_filter(explode(',', $usernames)),
        $includeEmail === 'y'
    );
}

function getUsersFollows(Client $guzzleClient): ResponseInterface
{
    echo 'GET USERS FOLLOWS'.PHP_EOL;
    echo 'Follower ID: ';
    $followerId = (int) trim(fgets(STDIN));
    echo 'Followee ID: ';
    $followeeId = (int) trim(fgets(STDIN));

    return (new Users($guzzleClient))->getUsersFollows(
        $followerId,
        $followeeId
    );
}

