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

    /** @var array|null */
    public $invoice;

    /** @var array|null */
    public $transfer;

    /** @var int */ // todo change to bool?
    public $status;

    /** @var string */
    public $statusLabel;

    /** @var string */
    public $createdAt;

    /** @var string */
    public $updatedAt;

    protected function fill(array $attributes): void
    {
        foreach ($attributes as $key => $value) {

            if ($key === 'invoice' || $key === 'transfer') {
                $this->{$key} = (array)$value;
                continue;
            }

            $key = $this->camelCase($key);

            $this->{$key} = $value;

        }

    }

}