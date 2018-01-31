<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Resources;

class Transfer extends AbstractResource
{
    /** @var int */
    public $id;

    /** @var int|float */
    public $amount;

    /** @var int|float */
    public $commission;

    /** @var int */
    public $status;

    /** @var string */
    public $statusLabel;

    /** @var string */
    public $createdAt;

    /** @var string */
    public $updatedAt;
}