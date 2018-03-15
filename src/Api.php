<?php

declare(strict_types=1);

namespace AcquiroPay;

use AcquiroPay\Exceptions\ForbiddenException;
use AcquiroPay\Exceptions\NotFoundException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use AcquiroPay\Contracts\Cache;
use AcquiroPay\Exceptions\UnauthorizedException;

class Api
{
    protected $cache;
    protected $http;
    protected $logger;

    protected $url;
    protected $username;
    protected $password;

    public function __construct(Cache $cache, Client $http, LoggerInterface $logger = null)
    {
        $this->cache = $cache;
        $this->http = $http;
        $this->logger = $logger;
    }

    public function setUrl(string $url): Api
    {
        $this->url = $url;

        return $this;
    }

    public function setUsername(string $username): Api
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password): Api
    {
        $this->password = $password;

        return $this;
    }

    public function callService(string $service, string $method, string $endpoint, array $parameters = null)
    {
        return $this->call($method, '/services/' . $service, ['Endpoint' => $endpoint], $parameters);
    }

    public function call(string $method, string $endpoint, array $headers = [], array $parameters = null)
    {
        $stream = $this->makeCallRequest($method, $endpoint, $headers, $parameters);
        $json = json_decode((string)$stream);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $json;
        }

        return (string)$stream;
    }

    protected function makeCallRequest(
        string $method,
        string $endpoint,
        array $headers = [],
        array $parameters = null
    ): StreamInterface {
        $headers = array_merge([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token(),
        ], $headers);

        if (!Str::startsWith($endpoint, ['http://', 'https://'])) {
            $endpoint = $this->url . '/' . ltrim($endpoint, '/');
        }

        $body = $parameters !== null ? json_encode($parameters) : null;

        try {
            $response = $this->http->send(new Request($method, $endpoint, $headers, $body));
        } catch (ClientException $exception) {
            $response = $exception->getResponse();

            $statusCode = $response->getStatusCode() ?? null;

            switch ($statusCode) {
                case 404:
                    throw new NotFoundException;
                    break;
                case 403:
                    throw new ForbiddenException;
                    break;
            }

        }

        return $response->getBody();
    }

    /**
     * Authorize token for performing request.
     *
     * @param string $token
     * @param string $service
     * @param string $method
     * @param string $endpoint
     *
     * @return Consumer
     *
     * @throws UnauthorizedException
     */
    public function authorize(string $token, string $service, string $method, string $endpoint): Consumer
    {
        try {
            $headers = ['Content-Type' => 'application/json'];

            $url = $this->url . '/authorize';

            $body = json_encode(compact('token', 'service', 'method', 'endpoint'));

            $response = $this->http->send(new Request('POST', $url, $headers, $body));

            $json = \GuzzleHttp\json_decode((string)$response->getBody());

            if (!isset($json->authorized, $json->consumer_id) || $json->authorized !== true) {
                throw new UnauthorizedException;
            }

            return Consumer::create($json->consumer_id);
        } catch (Exception $exception) {
            if ($this->logger) {
                $this->logger->error($exception);
            }

            throw new UnauthorizedException('', 0, $exception);
        }
    }

    protected function token(): ?string
    {
        return $this->cache->remember('acquiropay_api_token_' . md5($this->url), 10, function () {
            $response = $this->http->post($this->url . '/login',
                ['form_params' => ['username' => $this->username, 'password' => $this->password]]);

            return (string)$response->getBody();
        });
    }
}
