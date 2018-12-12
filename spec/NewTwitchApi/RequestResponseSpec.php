<?php

namespace spec\NewTwitchApi;

use NewTwitchApi\RequestResponse;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestResponseSpec extends ObjectBehavior
{
    function let(RequestInterface $request, ResponseInterface $response)
    {
        $this->beConstructedWith($request, $response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RequestResponse::class);
    }

    function it_should_provide_the_request(RequestInterface $request)
    {
        $this->getRequest()->shouldBe($request);
    }

    function it_should_provide_the_response(ResponseInterface $response)
    {
        $this->getResponse()->shouldBe($response);
    }
}
