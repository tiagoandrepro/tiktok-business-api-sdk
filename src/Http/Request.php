<?php

namespace Tiagoandrepro\TiktokBusinessApiSdk\Http;
class Request
{
    protected $method;
    protected $url;
    protected $headers;
    protected $body;

    public function __construct(string $method, string $url, array $headers = [], $body = null)
    {
        $this->method = strtoupper($method);
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }
}