<?php

use TwitchApi\NewApi\CLI\CLIClient;

require __DIR__ . '/../vendor/autoload.php';

try {
    (new CLIClient($argv))->run();
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
