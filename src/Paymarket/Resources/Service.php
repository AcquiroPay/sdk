<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Resources;

class Service extends AbstractResource
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $name;

    /** @var  int */
    public $minAmount;

    /** @var  int */
    public $maxAmount;

    /** @var  string */
    public $className;

    /** @var  int */
    public $isActive;

    /** @var string */
    public $createdAt;

    /** @var string */
    public $updatedAt;

}