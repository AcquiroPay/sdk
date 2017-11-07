<?php

declare(strict_types=1);

namespace AcquiroPay\Cache;

use Closure;
use AcquiroPay\Contracts\Cache;
use Illuminate\Cache\Repository;

class LaravelCache implements Cache
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function remember(string $key, int $minutes, Closure $callback)
    {
        return $this->repository->remember($key, $minutes, $callback);
    }
}
