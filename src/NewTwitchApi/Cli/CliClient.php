<?php

declare(strict_types = 1);

namespace NewTwitchApi\Cli;

use Exception;
use InvalidArgumentException;
use NewTwitchApi\Auth\AuthGuzzleClient;
use NewTwitchApi\Cli\CliEndpoints\CliEndpointInterface;
use NewTwitchApi\Cli\CliEndpoints\ExitCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetStreamsCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetUsersCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\GetUsersFollowsCliEndpoint;
use NewTwitchApi\Cli\CliEndpoints\RefreshTokenCliEndpoint;
use NewTwitchApi\HelixGuzzleClient;

class CliClient
{
    /** @var array */
    private $endpoints;
    private $clientId;
    private $clientSecret;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(array $argv)
    {
        if (!isset($argv[1], $argv[2])) {
            throw new InvalidArgumentException(sprintf('Usage: php %s <client-id> <client-secret>', $argv[0]));
        }

        $this->clientId = $argv[1];
        $this->clientSecret = $argv[2];

        $helixGuzzleClient = new HelixGuzzleClient($this->clientId);
        $this->endpoints = [
            new ExitCliEndpoint(),
            new RefreshTokenCliEndpoint($this->clientId, $this->clientSecret),
            new GetUsersCliEndpoint($helixGuzzleClient),
            new GetUsersFollowsCliEndpoint($helixGuzzleClient),
            new GetStreamsCliEndpoint($helixGuzzleClient),
        ];
    }

    public function run(): void
    {
        echo 'Twitch API Testing Tool'.PHP_EOL;

        while (true) {
            try {
                $endpoint = $this->promptForEndpoint();
                echo $endpoint->getName().PHP_EOL;
                $requestResponse = $endpoint->execute();
                echo PHP_EOL.$requestResponse->getRequest()->getRequestTarget().PHP_EOL;
                echo PHP_EOL.json_encode(json_decode($requestResponse->getResponse()->getBody()->getContents()), JSON_PRETTY_PRINT).PHP_EOL;
            } catch (Exception $e) {
                echo $e->getMessage().PHP_EOL;
            }
        }
    }

    /** @throws InvalidArgumentException */
    private function promptForEndpoint(): CliEndpointInterface
    {
        echo PHP_EOL;
        echo 'Which endpoint would you like to call?'.PHP_EOL;
        foreach ($this->endpoints as $key => $endpoint) {
            echo sprintf('%d) %s'.PHP_EOL, $key, $endpoint->getName());
        }
        echo 'Choice: ';
        $choice = (int) fgets(STDIN);
        echo PHP_EOL;

        if (!array_key_exists($choice, $this->endpoints)) {
            throw new InvalidArgumentException('Invalid choice.');
        }

        return $this->endpoints[$choice];
    }
}
