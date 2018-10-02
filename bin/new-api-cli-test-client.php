<?php

require __DIR__ . '/../vendor/autoload.php';

use TwitchApi\NewApi\CLI\CLIClient;

try {
    (new CLIClient($argv))->run();
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
