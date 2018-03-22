<?php

declare(strict_types=1);

namespace AcquiroPay;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;
use AcquiroPay\Contracts\Cache;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Exception\ClientException;
use AcquiroPay\Exceptions\NotFoundException;
use AcquiroPay\Exceptions\ForbiddenException;
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

    /**
     * @param string $service
     * @param string $method
     * @param string $endpoint
     * @param array|null $parameters
     *
     * @return mixed|string
     *
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function callService(string $service, string $method, string $endpoint, array $parameters = null)
    {
        return $this->call($method, '/services/'.$service, ['Endpoint' => $endpoint], $parameters);
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $headers
     * @param array|null $parameters
     *
     * @return mixed|string
     *
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function call(string $method, string $endpoint, array $headers = [], array $parameters = null)
    {
        $stream = $this->makeCallRequest($method, $endpoint, $headers, $parameters);
        $json = json_decode((string) $stream);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $json;
        }

        return (string) $stream;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $headers
     * @param array|null $parameters
     * @param bool $retry
     * @return StreamInterface
     *
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    protected function makeCallRequest(
        string $method,
        string $endpoint,
        array $headers = [],
        array $parameters = null,
        bool $retry = true
    ): StreamInterface {
        $method = Str::upper($method);
        if (!Str::startsWith($endpoint, ['http://', 'https://'])) {
            $endpoint = $this->url.'/'.ltrim($endpoint, '/');
        }

        try {
            $options = [
                'headers' => array_merge([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->token(),
                ], $headers),
            ];

            if ($method === 'GET') {
                $options['query'] = $parameters;
            } else {
                $options['json'] = $parameters;
            }

            return $this->http->request($method, $endpoint, $options)->getBody();
        } catch (ClientException $exception) {
            if ($this->logger) {
                $this->logger->error($exception);
            }

            $response = $exception->getResponse();

            if ($retry && $response && $response->getStatusCode() === 401) {
                $this->token();

                return $this->makeCallRequest($method, $endpoint, $headers, $parameters, false);
            }

            switch ($response->getStatusCode()) {
                case 404:
                    throw new NotFoundException($response->getBody()->getContents());
                    break;
                case 403:
                    throw new ForbiddenException;
                    break;
            }

            throw $exception;
        }
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

            $url = $this->url.'/authorize';

            $body = json_encode(compact('token', 'service', 'method', 'endpoint'));

            $response = $this->http->send(new Request('POST', $url, $headers, $body));

            $json = \GuzzleHttp\json_decode((string) $response->getBody());

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
        return $this->cache->remember('acquiropay_api_token_'.md5($this->url), 10, function () {
            $response = $this->http->post(
                $this->url.'/login',
                ['form_params' => ['username' => $this->username, 'password' => $this->password]]
            );

            return (string) $response->getBody();
        });
    }
}
