<?php

declare(strict_types=1);

namespace AcquiroPay\Gateway\Responses;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class PaymentStatusByCfResponse implements Arrayable
{
    private $paymentId;
    private $status;
    private $extendedId;
    private $extendedStatus;
    private $transactionStatus;
    private $datetime;
    private $duplicate;
    private $additional;

    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    public function setPaymentId(string $paymentId): self
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getExtendedId(): ?string
    {
        return $this->extendedId;
    }

    public function setExtendedId(string $extendedId): self
    {
        $this->extendedId = $extendedId;

        return $this;
    }

    public function getExtendedStatus(): ?string
    {
        return $this->extendedStatus;
    }

    public function setExtendedStatus(string $extendedStatus): self
    {
        $this->extendedStatus = $extendedStatus;

        return $this;
    }

    public function getTransactionStatus(): ?string
    {
        return $this->transactionStatus;
    }

    public function setTransactionStatus(string $transactionStatus): self
    {
        $this->transactionStatus = $transactionStatus;

        return $this;
    }

    public function getDatetime(): ?Carbon
    {
        return $this->datetime;
    }

    public function setDatetime(string $datetime): self
    {
        $this->datetime = Carbon::parse($datetime);

        return $this;
    }

    public function getDuplicate(): bool
    {
        return $this->duplicate;
    }

    public function setDuplicate(string $duplicate): self
    {
        $this->duplicate = $duplicate === 'true';

        return $this;
    }

    public function getAdditional(): ?array
    {
        return $this->additional;
    }

    public function setAdditional(array $additional): self
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'payment_id' => $this->paymentId,
            'status' => $this->status,
            'extended_id' => $this->extendedId,
            'extended_status' => $this->extendedStatus,
            'transaction_status' => $this->transactionStatus,
            'datetime' => $this->datetime,
            'duplicate' => $this->duplicate,
            'additional' => $this->additional,
        ];
    }
}
