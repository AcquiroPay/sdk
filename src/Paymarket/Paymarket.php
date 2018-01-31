<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket;

use AcquiroPay\Api;
use AcquiroPay\Paymarket\Actions\ManagesServices;
use AcquiroPay\Paymarket\Actions\ManagesTransactions;

class Paymarket
{
    use MakesHttpRequests,
        ManagesServices,
        ManagesTransactions;

    /** @var \GuzzleHttp\Client */
    public $client;

    public function __construct(Api $api)
    {
        $this->api = $api;
        $this->serviceName = 'paymarket';
    }

    protected function transformCollection(array $collection, string $class): array
    {
        return array_map(function ($attributes) use ($class) {
            return new $class($attributes, $this);
        }, $collection);
    }

}