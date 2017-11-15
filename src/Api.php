<?php

declare(strict_types=1);

namespace AcquiroPay;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use AcquiroPay\Contracts\Cache;

class Api
{
    protected $cache;
    protected $http;

    protected $url;
    protected $username;
    protected $password;

    public function __construct(Cache $cache, Client $http)
    {
        $this->cache = $cache;
        $this->http = $http;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function callService(string $service, string $method, string $endpoint, array $parameters = null)
    {
        return $this->call($method, '/services/'.$service, ['Endpoint' => $endpoint], $parameters);
    }

    public function call(string $method, string $endpoint, array $headers = [], array $parameters = null)
    {
        $body = null;

        $headers = array_merge([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->token(),
        ], $headers);

        if (!Str::startsWith($endpoint, ['http://', 'https://'])) {
            $endpoint = $this->url.'/'.ltrim($endpoint, '/');
        }

        if ($parameters !== null) {
            $body = json_encode($parameters);
        }

        $response = $this->http->send(new Request($method, $endpoint, $headers, $body));

        $json = json_decode((string) $response->getBody());

        if(json_last_error() === JSON_ERROR_NONE) {
            return $json;
        }

        return (string) $response->getBody();
    }

    public function authorize(string $token, string $service, string $method, string $endpoint): bool
    {
        try {
            $headers = ['Content-Type' => 'application/json'];

            $url = $this->url.'/authorize';

            $body = json_encode(compact('token', 'service', 'method', 'endpoint'));

            $this->http->send(new Request('POST', $url, $headers, $body));

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    protected function token(): ?string
    {
        return $this->cache->remember('api_token_'.md5($this->url), 10, function () {
            $response = $this->http->post($this->url.'/login', ['form_params' => ['username' => $this->username, 'password' => $this->password]]);

            return (string) $response->getBody();
        });
    }
}
