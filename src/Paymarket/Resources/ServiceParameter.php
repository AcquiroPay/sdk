<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Resources;

class ServiceParameter extends AbstractResource
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $value;

    /** @var int */
    public $minLength;

    /** @var int */
    public $maxLength;

    /** @var string */
    public $description;

    /** @var string */
    public $pattern;

    /** @var string */
    public $type;

    /** @var array */
    public $meta;

    /** @var string */
    public $createdAt;

    /** @var string */
    public $updatedAt;
}
