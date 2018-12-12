<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

class GetGamesCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get Games';
    }

    public function execute(): RequestResponse
    {
        $this->getOutputWriter()->write('IDs (separated by commas): ');
        $ids = $this->getInputReader()->readCSVIntoArrayFromStdin();
        $this->getOutputWriter()->write('Names (separated by commas): ');
        $names = $this->getInputReader()->readCSVIntoArrayFromStdin();

        return $this->getTwitchApi()->getGamesApi()->getGames($ids, $names);
    }
}
