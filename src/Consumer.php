<?php

declare(strict_types=1);

namespace AcquiroPay;

use RuntimeException;

final class Consumer
{
    private $id;

    private static $instance;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function create(int $id): self
    {
        $instance = new self($id);

        self::$instance = $instance;

        return $instance;
    }

    public static function instance(): self
    {
        if (self::$instance === null) {
            throw new RuntimeException('No instance.');
        }

        return self::$instance;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
