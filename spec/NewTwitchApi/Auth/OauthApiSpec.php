<?php

namespace spec\NewTwitchApi\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use NewTwitchApi\Auth\OauthApi;
use PhpSpec\ObjectBehavior;

class OauthApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith('client-id', 'client-secret', $guzzleClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OauthApi::class);
    }

    function it_should_get_auth_url()
    {
        $this->getAuthUrl('https://redirect.url')->shouldReturn(
            'authorize?client_id=client-id&redirect_uri=https://redirect.url&response_type=code&scope='
        );
    }

    function it_should_get_full_auth_url(Client $guzzleClient)
    {
        $guzzleClient->getConfig('base_uri')->willReturn('https://id.twitch.tv/oauth2/');
        $this->getFullAuthUrl('https://redirect.url')->shouldReturn(
            'https://id.twitch.tv/oauth2/authorize?client_id=client-id&redirect_uri=https://redirect.url&response_type=code&scope='
        );
    }

    function it_should_authorize_user(Client $guzzleClient, Response $response)
    {
        $request = new Request('GET', 'authorize?client_id=client-id&redirect_uri=https://redirect.url&response_type=code&scope=');
        $guzzleClient->send($request, [])->willReturn($response);

        $requestResponse = $this->authorizeUser('https://redirect.url');
        $requestResponse->getRequest()->getMethod()->shouldBe('GET');
        $requestResponse->getRequest()->getUri()->getQuery()->shouldBe('client_id=client-id&redirect_uri=https://redirect.url&response_type=code&scope=');
        $requestResponse->getResponse()->shouldBe($response);
    }

    function it_should_get_access_token(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'POST',
            'token'
        );
        $guzzleClient->send($request, ['json' => [
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'https://redirect.url',
            'code' => 'user-code-from-twitch',
            'state' => null,
        ]])->willReturn($response);

        $requestResponse = $this->getAccessToken('user-code-from-twitch', 'https://redirect.url');
        $requestResponse->getRequest()->getMethod()->shouldBe('POST');
        $requestResponse->getResponse()->shouldBe($response);
    }

    function it_should_get_refresh_token(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'POST',
            'token'
        );
        $guzzleClient->send($request, ['json' => [
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'grant_type' => 'refresh_token',
            'refresh_token' => 'user-refresh-token',
        ]])->willReturn($response);

        $requestResponse = $this->refreshToken('user-refresh-token');
        $requestResponse->getRequest()->getMethod()->shouldBe('POST');
        $requestResponse->getResponse()->shouldBe($response);
    }

    function it_should_validate_access_token(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'GET',
            'validate',
            [
                'Authorization' => 'OAuth user-access-token',
            ]
        );
        $guzzleClient->send($request, [])->willReturn($response);

        $requestResponse = $this->validateAccessToken('user-access-token');
        $requestResponse->getRequest()->getMethod()->shouldBe('GET');
        $requestResponse->getResponse()->shouldBe($response);
    }

    function it_should_return_true_if_access_token_is_valid(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'GET',
            'validate',
            [
                'Authorization' => 'OAuth user-access-token',
            ]
        );
        $response->getStatusCode()->willReturn(200);
        $guzzleClient->send($request, [])->willReturn($response);

        $this->isValidAccessToken('user-access-token')->shouldReturn(true);
    }

    function it_should_return_false_if_access_token_is_invalid(Client $guzzleClient, Response $response)
    {
        $request = new Request(
            'GET',
            'validate',
            [
                'Authorization' => 'OAuth invalid-user-access-token',
            ]
        );
        $response->getStatusCode()->willReturn(401);
        $guzzleClient->send($request, [])->willReturn($response);

        $this->isValidAccessToken('invalid-user-access-token')->shouldReturn(false);
    }
}