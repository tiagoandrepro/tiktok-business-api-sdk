<?php

namespace Tiagoandrepro\TiktokBusinessApiSdk\Auth;

use Tiagoandrepro\TiktokBusinessApiSdk\Http\Client;
use Tiagoandrepro\TiktokBusinessApiSdk\Exceptions\HttpException;
use Tiagoandrepro\TiktokBusinessApiSdk\Http\Request;

class OAuth
{
    public function __construct(
        protected Client $httpClient,
        protected string $appId,
        protected string $clientSecret,
        protected string $redirectUrl
    )
    {
        //
    }

    public function getAuthorizationUrl(string $state = null, array $customParams = []): string
    {
        $params = array_merge([
            'client_key' => $this->appId,
            'state' => $state,
            'redirect_uri' => $this->redirectUrl,
            'response_type' => 'code',
            'disable_auto_auth' => 1,
            'scope' => 'user.info.basic,user.info.username,user.info.stats,user.account.type,user.insights,video.list,video.insights,comment.list,comment.list.manage,video.publish',
        ], $customParams);

        $queryString = http_build_query($params);

       return  "https://www.tiktok.com/v2/auth/authorize?{$queryString}";
    }

    public function accountHolderAuthorization()
    {

    }

    public function getAccessToken(string $code)
    {
        try {
            $request = new Request('POST', 'oauth2/access_token', [], [
                'app_id' => $this->appId,
                'secret' => $this->clientSecret,
                'auth_code' => $code,
                'grant_type' => 'authorization_code',
            ]);

            $response = $this->httpClient->request($request);

            if (isset($data['error_code']) && $data['error_code'] !== 0) {
                throw new HttpException("TikTok API Error: {$data['message']}");
            }

            return $response;
        } catch (\Exception $e) {
            throw new HttpException("Failed to retrieve access token", $e->getCode(), $e);
        }
    }
}
