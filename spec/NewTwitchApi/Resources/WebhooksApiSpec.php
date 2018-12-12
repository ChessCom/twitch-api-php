<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\RequestResponse;
use NewTwitchApi\Resources\WebhooksApi;
use PhpSpec\ObjectBehavior;

class WebhooksApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(WebhooksApi::class);
    }

    function it_should_get_user_with_access_token_convenience_method(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'webhooks/subscriptions', ['Authorization' => 'Bearer access-token']))->willReturn($response);
        $this->getWebhookSubscriptions('access-token')->shouldBeAnInstanceOf(RequestResponse::class);
    }
}