
# TikTok Business API SDK for PHP

Este SDK em PHP permite a integração fácil com a TikTok Business API, facilitando a autenticação OAuth e a interação com as funcionalidades da API. Ele foi desenvolvido seguindo os padrões de design recomendados e é modular, tornando-o fácil de estender e manter.

## Funcionalidades

- **Autenticação OAuth 2.0**: Realize a autenticação e obtenha tokens de acesso para interagir com a API do TikTok.
- **Requisições HTTP Simples**: Envie requisições HTTP para a API do TikTok com classes estruturadas de `Request` e `Response`.
- **Manuseio de Exceções**: Lide com erros da API de forma robusta usando exceções personalizadas.

## Instalação

Primeiro, você precisa instalar o SDK via Composer:

```bash
composer require tiagoandrepro/tiktok-business-api-sdk
```

## Uso Básico

### 1. Configuração da Autenticação OAuth

Primeiro, configure os detalhes do aplicativo TikTok e instancie as classes necessárias:

```php
require 'vendor/autoload.php';

use Tiagoandrepro\TiktokBusinessApiSdk\Http\Client;
use Tiagoandrepro\TiktokBusinessApiSdk\Auth\OAuth;

$httpClient = new Client();

// Valores dinâmicos
$appId = 'SEU_APP_ID';
$clientSecret = 'SEU_APP_SECRET';
$redirectUrl = 'https://seu_dominio.com/callback';

// Instancia a classe OAuth com os valores dinâmicos
$oauth = new OAuth($httpClient, $appId, $clientSecret, $redirectUrl);

// Gera a URL de autorização dinamicamente
$authorizationUrl = $oauth->getAuthorizationUrl('random_state_string');
```

### 2. Troca do Código de Autorização pelo Token de Acesso

Após o redirecionamento para o `redirectUri`, capture o código de autorização e troque-o por um token de acesso:

```php
require 'vendor/autoload.php';

use Tiagoandrepro\TiktokBusinessApiSdk\Http\Client;
use Tiagoandrepro\TiktokBusinessApiSdk\Auth\OAuth;

$httpClient = new Client();

// Valores dinâmicos
$appId = 'SEU_APP_ID';
$clientSecret = 'SEU_APP_SECRET';
$redirectUrl = 'https://seu_dominio.com/callback';

$oauth = new OAuth($httpClient, $appId, $clientSecret, $redirectUrl);

// Receber o código de autorização que foi enviado pelo TikTok após a autenticação
$code = $_GET['code'] ?? null;

if ($code) {
    $accessTokenData = $oauth->getAccessToken($code);
}
```

### 3. Fazendo Requisições à API para Obter o Token de Acesso

Com o código de autorização, você pode trocar por um token de acesso:

```php
use Tiagoandrepro\TiktokBusinessApiSdk\Http\Request;
use Tiagoandrepro\TiktokBusinessApiSdk\Http\Client;
use Tiagoandrepro\TiktokBusinessApiSdk\Exceptions\HttpException;

$httpClient = new Client();

public function getAccessToken(string $code): \Tiagoandrepro\TiktokBusinessApiSdk\Http\Response
{
    try {
        $request = new Request('POST', 'oauth2/access_token', [], [
            'app_id' => $this->appId,
            'secret' => $this->clientSecret,
            'auth_code' => $code,
            'grant_type' => 'authorization_code',
        ]);

        $response = $this->httpClient->request($request);

        if (isset($data['code']) && $data['code'] !== 0) {
            throw new HttpException("TikTok API Error: {$data['message']}");
        }

        return $response;
    } catch (\Exception $e) {
        throw new HttpException("Failed to retrieve access token", $e->getCode(), $e);
    }
}
```

## Contribuindo

Se você deseja contribuir com este projeto, por favor, siga estas etapas:

1. **Fork** o repositório.
2. Crie uma nova branch: `git checkout -b minha-feature`.
3. Faça suas alterações e **commit**: `git commit -m 'Adicionar nova feature'`.
4. **Push** para a branch: `git push origin minha-feature`.
5. Envie um **Pull Request**.

## Licença

Este projeto é licenciado sob a [MIT License](LICENSE).
