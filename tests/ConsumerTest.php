<?php

declare(strict_types=1);

namespace Tests;

use AcquiroPay\Consumer;
use PHPUnit\Framework\TestCase;

class ConsumerTest extends TestCase
{
    public function testSingleton()
    {
        $consumer = Consumer::create($id = random_int(1, PHP_INT_MAX));

        $this->assertAttributeSame($id, 'id', $consumer);
        $this->assertAttributeSame($id, 'id', Consumer::instance());
    }
}