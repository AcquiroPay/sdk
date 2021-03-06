<?php

declare(strict_types=1);

namespace Tests\Cache;

use PHPUnit\Framework\TestCase;
use AcquiroPay\Cache\ArrayCache;

class ArrayCacheTest extends TestCase
{
    public function test()
    {
        $cache = new ArrayCache;

        $result = $cache->remember('foo', 0, function () {
            return random_int(1, 100);
        });

        $this->assertInternalType('integer', $result);

        $newResult = $cache->remember('foo', 0, function () {
            return 'bar';
        });

        $this->assertNotEquals('bar', $newResult);
        $this->assertSame($result, $newResult);
    }
}
