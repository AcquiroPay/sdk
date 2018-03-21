<?php

declare(strict_types=1);

namespace AcquiroPay\Cache;

use Closure;
use AcquiroPay\Contracts\Cache;

class ArrayCache implements Cache
{
    protected $items = [];

    public function remember(string $key, int $minutes, Closure $callback)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }

        return $this->items[$key] = value($callback);
    }
}
