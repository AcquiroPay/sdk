<?php

declare(strict_types=1);

namespace AcquiroPay\Gateway\Responses;

use Illuminate\Contracts\Support\Arrayable;

class InitResponse implements Arrayable
{
    private $paymentId;
    private $status;
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
            'additional' => $this->additional,
        ];
    }
}