<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;
use NewTwitchApi\Resources\Games;

class GetGamesCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get Games';
    }

    public function execute(): RequestResponse
    {
        echo 'IDs (separated by commas): ';
        $ids = $this->readCSVIntoArrayFromStdin();
        echo 'Names (separated by commas): ';
        $names = $this->readCSVIntoArrayFromStdin();

        return (new Games($this->guzzleClient))->getUsers($ids, $names);
    }
}
