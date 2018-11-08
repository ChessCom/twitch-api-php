<?php

namespace spec\TwitchApi\NewApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use TwitchApi\NewApi\RequestResponse;
use TwitchApi\NewApi\Resources\Streams;

class StreamsSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Streams::class);
    }

    function it_should_get_streams_by_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?id=12345&id=98765'))->willReturn($response);
        $this->getStreams([12345,98765])->shouldBeAnInstanceOf(RequestResponse::class);
    }

    function it_should_get_streams_by_usernames(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_login=twitchuser&user_login=anotheruser'))->willReturn($response);
        $this->getStreams([], ['twitchuser','anotheruser'])->shouldBeAnInstanceOf(RequestResponse::class);
    }

    function it_should_get_streams_by_id_and_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?id=12345&id=98765&user_login=twitchuser&user_login=anotheruser'))->willReturn($response);
        $this->getStreams([12345,98765], ['twitchuser','anotheruser'])->shouldBeAnInstanceOf(RequestResponse::class);
    }

    function it_should_get_a_single_user_by_id(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?id=12345'))->willReturn($response);
        $this->getStreamForUserId(12345)->shouldBeAnInstanceOf(RequestResponse::class);
    }

    function it_should_get_a_single_user_by_username(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'streams?user_login=twitchuser'))->willReturn($response);
        $this->getStreamForUsername('twitchuser')->shouldBeAnInstanceOf(RequestResponse::class);
    }
}
