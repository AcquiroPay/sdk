<?php

declare(strict_types=1);

namespace AcquiroPay\Contracts;

use Closure;

interface Cache
{
    public function remember(string $key, int $minutes, Closure $callback);
}
