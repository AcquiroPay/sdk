<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Resources;

class Transaction extends AbstractResource
{
    /** @var int */
    public $id;

    /** @var int */
    public $merchantId;

    /** @var int */
    public $serviceId;

    /** @var string */
    public $externalId;

    /** @var string */
    public $uuid;

    /** @var int|float */
    public $amount;

    /** @var array */
    public $parameters;

    /** @var Invoice|null */
    public $invoice;

    /** @var Transfer|null */
    public $transfer;

    /** @var int */
    public $status;

    /** @var string */
    public $statusLabel;

    /** @var string */
    public $createdAt;

    /** @var string */
    public $updatedAt;

    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->invoice = $attributes['invoice'] ? new Invoice($attributes['invoice']) : null;
        $this->transfer = $attributes['transfer'] ? new Transfer($attributes['transfer']) : null;
    }

    public function hasInvoice(): bool
    {
        return (bool) $this->invoice;
    }

    public function hasTransfer(): bool
    {
        return (bool) $this->transfer;
    }
}
