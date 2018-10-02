<?php

declare(strict_types = 1);

namespace TwitchApi\NewApi\CLI;

use Exception;
use InvalidArgumentException;
use TwitchApi\NewApi\HelixGuzzleClient;

class CLIClient
{
    /** @var array */
    private $endpoints;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(array $argv)
    {
        if (!isset($argv[1])) {
            throw new InvalidArgumentException(sprintf('Usage: php %s <client-id>', $argv[0]));
        }

        $guzzleClient = new HelixGuzzleClient($argv[1]);
        $this->endpoints = [
            /*
             *  Start indexing at 1 instead of 0, so that a null choice from the user (pressing return with no input)
             *  doesn't execute an endpoint when `(int) null` becomes `0`.
             */
            1 => new GetUsersCLIEndpoint($guzzleClient),
            new GetUsersFollowsCLIEndpoint($guzzleClient),
            new GetStreamsCLIEndpoint($guzzleClient),
        ];
    }

    public function run(): void
    {
        echo 'Twitch API Testing Tool'.PHP_EOL;

        while (true) {
            try {
                $endpoint = $this->promptForEndpoint();
                echo $endpoint->getName().PHP_EOL;
                $response = $endpoint->execute();
                echo PHP_EOL.json_encode(json_decode($response->getBody()->getContents()), JSON_PRETTY_PRINT).PHP_EOL;
            } catch (Exception $e) {
                echo $e->getMessage().PHP_EOL;
            }
        }
    }

    /** @throws InvalidArgumentException */
    private function promptForEndpoint(): CLIEndpointInterface
    {
        echo PHP_EOL;
        echo 'Which endpoint would you like to call?'.PHP_EOL;
        foreach ($this->endpoints as $key => $endpoint) {
            echo sprintf('%d) %s'.PHP_EOL, $key, $endpoint->getName());
        }
        echo 'Choice (Ctrl-c to exit): ';
        $choice = (int) fgets(STDIN);
        echo PHP_EOL;

        if (!array_key_exists($choice, $this->endpoints)) {
            throw new InvalidArgumentException('Invalid choice.');
        }

        return $this->endpoints[$choice];
    }
}
