<?php

namespace NewTwitchApi\Cli\CliEndpoints;

use NewTwitchApi\RequestResponse;

class GetStreamsCliEndpoint extends AbstractCliEndpoint
{
    public function getName(): string
    {
        return 'Get Streams';
    }

    public function execute(): RequestResponse
    {
        $this->getOutputWriter()->write('IDs (separated by commas): ');
        $ids = $this->getInputReader()->readCSVIntoArrayFromStdin();
        $this->getOutputWriter()->write('Usernames (separated by commas): ');
        $usernames = $this->getInputReader()->readCSVIntoArrayFromStdin();
        $this->getOutputWriter()->write('Games (separated by commas): ');
        $games = $this->getInputReader()->readCSVIntoArrayFromStdin();
        $this->getOutputWriter()->write('Communities (separated by commas): ');
        $communities = $this->getInputReader()->readCSVIntoArrayFromStdin();
        $this->getOutputWriter()->write('Languages (separated by commas): ');
        $languages = $this->getInputReader()->readCSVIntoArrayFromStdin();
        $this->getOutputWriter()->write('Max results to return: ');
        $first = $this->getInputReader()->readIntFromStdin();
        $this->getOutputWriter()->write('Cursor value previous page starts with: ');
        $before = $this->getInputReader()->readFromStdin();
        $this->getOutputWriter()->write('Cursor value next page starts with: ');
        $after = $this->getInputReader()->readFromStdin();

        return $this->getTwitchApi()->getStreamsApi()->getStreams(
            $ids,
            $usernames,
            $games,
            $communities,
            $languages,
            $first,
            $before,
            $after
        );
    }
}
