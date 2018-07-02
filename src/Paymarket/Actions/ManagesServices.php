<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Actions;

use AcquiroPay\Paymarket\Resources\Service;
use AcquiroPay\Paymarket\Resources\ServiceRate;

trait ManagesServices
{
    public function getServices(): array
    {
        return $this->transformCollection(
            array_get($this->get('services'), 'data', []),
            Service::class
        );
    }

    public function getService(int $serviceId): Service
    {
        return new Service(
            array_get($this->get('services/' . $serviceId), 'data', [])
        );
    }

    public function getServiceRate(int $serviceId): ServiceRate
    {
        return new ServiceRate(
            array_get($this->get('services/' . $serviceId . '/rate'), 'data', [])
        );
    }
}
