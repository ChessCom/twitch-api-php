<?php

namespace TwitchApi\NewApi\CLI;

use TwitchApi\NewApi\RequestResponse;
use TwitchApi\NewApi\Streams;

class GetStreamsCLIEndpoint extends CLIEndpoint
{
    public function getName(): string
    {
        return 'Get Streams';
    }

    public function execute(): RequestResponse
    {
        echo 'IDs (separated by commas): ';
        $ids = $this->readCSVIntoArrayFromStdin();
        echo 'Usernames (separated by commas): ';
        $usernames = $this->readCSVIntoArrayFromStdin();
        echo 'Games (separated by commas): ';
        $games = $this->readCSVIntoArrayFromStdin();
        echo 'Communities (separated by commas): ';
        $communities = $this->readCSVIntoArrayFromStdin();
        echo 'Languages (separated by commas): ';
        $languages = $this->readCSVIntoArrayFromStdin();
        echo 'Max results to return: ';
        $first = $this->readIntFromStdin();
        echo 'Cursor value previous page starts with: ';
        $before = $this->readFromStdin();
        echo 'Cursor value next page starts with: ';
        $after = $this->readFromStdin();

        return (new Streams($this->guzzleClient))->getStreams(
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
