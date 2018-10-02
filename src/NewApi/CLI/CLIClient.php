<?php

declare(strict_types = 1);

namespace TwitchApi\NewApi\CLI;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use TwitchApi\NewApi\HelixGuzzleClient;
use TwitchApi\NewApi\Users;

class CLIClient
{
    /** @var Client */
    private $guzzleClient;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(array $argv)
    {
        if (!isset($argv[1])) {
            throw new InvalidArgumentException(sprintf('Usage: php %s <client-id>', $argv[0]));
        }

        $this->guzzleClient = new HelixGuzzleClient($argv[1]);
    }

    public function run(): void
    {
        echo 'Twitch API Testing Tool'.PHP_EOL.PHP_EOL;

        while (true) {
            try {
                $this->printResponse($this->runChoice($this->getChoice()));
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
            }
        }
    }

    private function getChoice(): string
    {
        echo PHP_EOL;
        echo 'Which endpoint would you like to call? (Ctrl-c to exit)'.PHP_EOL;
        echo '1) GET USERS'.PHP_EOL;
        echo '2) GET USERS FOLLOWS'.PHP_EOL;
        echo 'Choice: ';

        return fgets(STDIN);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function runChoice(string $choice): ResponseInterface
    {
        switch ($choice) {
            case 1:
                return $this->getUsers();
            case 2:
                return $this->getUsersFollows();
            default:
                throw new InvalidArgumentException('Invalid choice.');
        }
    }

    private function printResponse(ResponseInterface $response): void
    {
        echo PHP_EOL.json_encode(json_decode($response->getBody()), JSON_PRETTY_PRINT).PHP_EOL;
    }

    private function getUsers(): ResponseInterface
    {
        echo 'GET USERS' . PHP_EOL;
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

    private function getUsersFollows(): ResponseInterface
    {
        echo 'GET USERS FOLLOWS' . PHP_EOL;
        echo 'Follower ID: ';
        $followerId = (int)trim(fgets(STDIN));
        echo 'Followee ID: ';
        $followeeId = (int)trim(fgets(STDIN));

        return (new Users($this->guzzleClient))->getUsersFollows(
            $followerId,
            $followeeId
        );
    }
}
