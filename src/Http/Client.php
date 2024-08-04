<?php

namespace Tiagoandrepro\TiktokBusinessApiSdk\Http;

use GuzzleHttp\Client as GuzzleClient;
use Tiagoandrepro\TiktokBusinessApiSdk\Exceptions\HttpException;
use Tiagoandrepro\TiktokBusinessApiSdk\Http\Request as HttpRequest;
use Tiagoandrepro\TiktokBusinessApiSdk\Http\Response as HttpResponse;

class Client
{
    protected GuzzleClient $httpClient;

    public function __construct()
    {
        $this->httpClient = new GuzzleClient([
                'base_uri' => 'https://business-api.tiktok.com/open_api/v1.3/'
            ]
        );
    }

    public function request(HttpRequest $request)
    {
        try {
            $guzzleResponse = $this->httpClient->request(
                $request->getMethod(),
                $request->getUrl(),
                [
                    'headers' => $request->getHeaders(),
                    'json' => $request->getBody()
                ]
            );

            return new HttpResponse(
                $guzzleResponse->getStatusCode(),
                $guzzleResponse->getBody(),
                $guzzleResponse->getHeaders()
            );
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}