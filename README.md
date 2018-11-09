# twitch-api-php

# New Twitch API (Helix)

A New Twitch API (Helix) client for PHP. The code for the new API is all contained within `src/NewApi/`. This is because the New API code is meant to be separate from the old Kraken API code, such that in the future, when Kraken is no longer available, the old Kraken code can be removed without affecting the new API code. Additionally, keeping them separate allows for existing code using the Kraken part of this library to continue to function, untouched by the new code.

The New Twitch API client is still being developed and is currently incomplete. If an endpoint you need is missing, incomplete, or not working correctly, please report it or fix it if you can and create a PR for it.

### CLI Test Client

In order to make testing the New Twitch API code easier, there is an interactive CLI script that can be run. This is found at `bin/new-api-cli-test-client.php`.

To run it, execute it with `bin/new-api-cli-test-client.php <client-id>`, passing in your client ID. The script will interactively walk you through the rest.

Here's a short example of the CLI test client in action.

```bash
$ ./bin/new-api-cli-test-client.php <CLIENT-ID>
Twitch API Testing Tool

Which endpoint would you like to call?
1) Get Users
2) Get Users Follows
3) Get Streams
Choice (Ctrl-c to exit): 1

Get Users
IDs (separated by commas):
Usernames (separated by commas): echosa
Include email address? (y/n)

users?login=echosa

{
    "data": [
        {
            "id": "60048855",
            "login": "echosa",
            "display_name": "echosa",
            "type": "",
            "broadcaster_type": "affiliate",
            "description": "Variety streamer. Single player games are best games. Schedule? What's a schedule? Kappa",
            "profile_image_url": "https:\/\/static-cdn.jtvnw.net\/jtv_user_pictures\/echosa-profile_image-220987d139410547-300x300.png",
            "offline_image_url": "https:\/\/static-cdn.jtvnw.net\/jtv_user_pictures\/echosa-channel_offline_image-f9d483b420e21c7d-1920x1080.png",
            "view_count": 2362
        }
    ]
}

Which endpoint would you like to call?
1) Get Users
2) Get Users Follows
3) Get Streams
Choice (Ctrl-c to exit): ^C
```

## Examples

```php
// TODO
```

## Requirements

PHP 7.1 or higher is required.

## Installation

Either pull in the library via composer:

```bash
composer require nicklaw5/twitch-api-php

```

or add the following dependency to your `composer.json` file and run `composer install`:

```json
"nicklaw5/twitch-api-php": "~1.0"
```

## Tests

### PHPUnit
All [PHPUnit](https://phpunit.de/) unit tests can be run with the following command:

```bash
vendor/bin/phpunit # or simply "phpunit" if you have it installed globally
```

This will run tests for both the New API code as well as the existing Kraken API code.

### PHPSpec

[PHPSpec](http://www.phpspec.net) has been added, specifically for the New Twitch API code. Specs can be run with the following command:

```bash
vendor/bin/phpspec run
```

## Developer Tools

### PHP Coding Standards Fixer

[PHP Coding Standards Fixer](https://cs.sensiolabs.org/) (`php-cs-fixer`) has been added, specifically for the New Twitch API code. A configuration file for it can be found in `.php_cs.dist`. The ruleset is left at default (PSR-2 at this time). The configuration file mostly just limits it's scope to only the New Twitch API code.

You can run the fixer with `vendor/bin/php-cs-fixer fix`. However, the easiest way to run the fixer is with the provided git hook.

### Git pre-commit Hook

In `bin/git/hooks`, you'll find a `pre-commit` hook that you can add to git that will automatically run the `php-cs-fixer` everytime you commit. The result is that, after the commit is made, any changes that fixer has made are left as unstaged changes. You can review them, then add and commit them.

To install the hook, go to `.git/hooks` and `ln -s ../../bin/git/hooks/pre-commit`.

## API Documentation

The New Twitch API docs can be found [here](https://dev.twitch.tv/docs/api/).

## License

Distributed under the [MIT](LICENSE) license.

---
---
---

# Kraken

A Twitch Kraken API client for PHP. This is the old API, which is deprecated and will be deleted soon. Please use Helix instead. If something is missing from the Helix API, please add it or request it.

The documentation below is left for legacy purposes, until Kraken support is removed.

[![Build Status](https://travis-ci.org/nicklaw5/twitch-api-php.svg?branch=master)](https://travis-ci.org/nicklaw5/twitch-api-php)

## Supported APIs

This library aims to support `v3` and `v5` of the Twitch API until each one becomes [deprecated](https://dev.twitch.tv/docs/v5). If an API version is not specified, `v5` will be used as the default.

## Features Completed

**Main API Endpoints:**

- [x] Authentication
- [x] Bits
- [x] Channel Feed
- [x] Channels
- [x] Chat
- [x] Clips
- [x] Collections
- [x] Communities
- [x] Games
- [x] Ingests
- [x] Search
- [x] Streams
- [x] Teams
- [x] Users
- [x] Videos

Any endpoints missing? Open an [issue here](https://github.com/nicklaw5/twitch-api-php/issues).

## Basic Example

```php
$options = [
    'client_id' => 'YOUR-CLIENT-ID',
];

$twitchApi = new \TwitchApi\TwitchApi($options);
$user = $twitchApi->getUser(26490481);

// By default API responses are returned as an array, but if you want the raw JSON instead:
$twitchApi->setReturnJson(true);
$user = $twitchApi->getUser(26490481);

// If you want to switch between API versions on the fly:
$twitchApi->setApiVersion(3);
$user = $twitchApi->getUser('summit1g');
```

See the [examples](examples) directory for more common use cases.

## Requirements

PHP 5.6 or higher is required.

## Installation

Either pull in the library via composer:

```bash
composer require nicklaw5/twitch-api-php

```

or add the following dependency to your `composer.json` file and run `composer install`:

```json
"nicklaw5/twitch-api-php": "~1.0"
```

## Tests

All unit tests can be run with the following command:

```bash
vendor/bin/phpunit # or simply "phpunit" if you have it installed globally
```

## Documentation

The Twitch API docs can be found [here](https://dev.twitch.tv/docs).

As for the documentation of this library, that is still on the to-do list. In the meantime, most modern IDEs by default, or through the use of plugins, will provide class property and method auto-completion. Or you can simple look through the [source](src) code.

## License

Distributed under the [MIT](LICENSE) license.
