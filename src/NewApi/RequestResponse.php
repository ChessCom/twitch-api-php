<?php

declare(strict_types=1);

namespace TwitchApi\NewApi;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestResponse
{
    private $request;
    private $response;

    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
