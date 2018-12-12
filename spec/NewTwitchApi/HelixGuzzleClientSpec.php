<?php

namespace spec\NewTwitchApi;

use GuzzleHttp\Psr7\Uri;
use NewTwitchApi\HelixGuzzleClient;
use PhpSpec\ObjectBehavior;

class HelixGuzzleClientSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('client-id');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HelixGuzzleClient::class);
    }

    function it_should_have_correct_base_uri()
    {
        /** @var Uri $uri */
        $uri = $this->getConfig('base_uri');
        $uri->getScheme()->shouldBe('https');
        $uri->getHost()->shouldBe('api.twitch.tv');
        $uri->getPath()->shouldBe('/helix/');
    }

    function it_should_have_client_id_header()
    {
        $this->getConfig('headers')->shouldHaveKeyWithValue('Client-ID', 'client-id');
    }

    function it_should_have_json_content_type_header()
    {
        $this->getConfig('headers')->shouldHaveKeyWithValue('Content-Type', 'application/json');
    }
}
