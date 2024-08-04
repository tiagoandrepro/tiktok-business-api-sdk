<?php

namespace Tiagoandrepro\TiktokBusinessApiSdk\Http;
class Response
{
    protected $statusCode;
    protected $body;
    protected $headers;

    public function __construct(int $statusCode, $body, array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody()
    {
        return json_decode($this->body, true);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function isSuccess(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }
}