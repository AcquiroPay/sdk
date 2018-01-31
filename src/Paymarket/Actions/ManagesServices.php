<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Actions;

use AcquiroPay\Paymarket\Resources\Service;

trait ManagesServices
{
    public function services(): array
    {
        return $this->transformCollection(
            $this->get('admin/services')['data'],
            Service::class
        );
    }

    public function service(int $id): Service
    {
        return new Service($this->get('admin/services/' . $id)['data']);
    }
}