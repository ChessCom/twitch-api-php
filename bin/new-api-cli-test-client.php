#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use NewTwitchApi\CLI\CLIClient;

try {
    (new CLIClient($argv))->run();
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
