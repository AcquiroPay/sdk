<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Actions;

use AcquiroPay\Paymarket\Resources\Service;

trait ManagesServices
{
    // todo loads all services with parameters?
    public function getServices(): array
    {
        return $this->transformCollection(
            $this->get('services')['data'],
            Service::class
        );
    }

    public function getService(int $id): Service
    {
        return new Service($this->get('services/' . $id)['data']);
    }
}