<?php

use GuzzleHttp\Client;
use TwitchApi\NewApi\HelixGuzzleClient;
use TwitchApi\NewApi\Users;

require __DIR__ . '/../vendor/autoload.php';

echo 'Twitch API Testing Tool'.PHP_EOL.PHP_EOL;

if (!isset($argv[1])) {
    echo 'Usage: php tester.php <client-id>';
    exit(1);
}
$guzzleClient = new HelixGuzzleClient($argv[1]);

echo PHP_EOL;
echo 'Which endpoint would you like to call?'.PHP_EOL;
echo '1) GET USERS'.PHP_EOL;
echo 'Choice: ';
$choice = fgets(STDIN);
switch ($choice) {
    case 1:
        getUsers($guzzleClient);
        break;
    default:
        echo 'Bad choice.'.PHP_EOL;
        exit(1);
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

