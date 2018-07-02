<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Resources;

class ServiceRate extends AbstractResource
{
    /** @var int */
    public $id;

    /** @var float */
    public $minAmount;

    /** @var float */
    public $maxAmount;

    /** @var float */
    public $percent;

    /** @var float */
    public $fixed;

    /** @var string */
    public $created_at;

    /** @var string */
    public $updated_at;
}
