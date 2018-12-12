<?php

namespace spec\NewTwitchApi\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use NewTwitchApi\Auth\AuthGuzzleClient;
use PhpSpec\ObjectBehavior;

class AuthGuzzleClientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AuthGuzzleClient::class);
        $this->shouldBeAnInstanceOf(Client::class);
    }

    function it_should_have_correct_base_uri()
    {
        /** @var Uri $uri */
        $uri = $this->getConfig('base_uri');
        $uri->getScheme()->shouldBe('https');
        $uri->getHost()->shouldBe('id.twitch.tv');
        $uri->getPath()->shouldBe('/oauth2/');
    }
}
