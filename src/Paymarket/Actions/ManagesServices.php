<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Actions;

use AcquiroPay\Paymarket\Resources\Service;

trait ManagesServices
{
    public function getServices(): array
    {
        return $this->transformCollection(
            array_get($this->get('services'), 'data', []),
            Service::class
        );
    }

    public function getService(int $id): Service
    {
        return new Service(
            array_get($this->get('services/'.$id), 'data', [])
        );
    }
}
