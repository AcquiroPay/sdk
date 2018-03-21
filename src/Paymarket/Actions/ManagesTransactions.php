<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Actions;

use AcquiroPay\Paymarket\Resources\Transaction;

trait ManagesTransactions
{
    public function getTransactions(): array
    {
        return $this->transformCollection(
            array_get($this->get('transactions'), 'data'),
            Transaction::class
        );
    }

    public function getTransaction(string $uuid): Transaction
    {
        return new Transaction(
            array_get($this->get('transactions/'.$uuid), 'data', [])
        );
    }

    public function createTransaction(array $parameters): array
    {
        return $this->post('transactions', $parameters);
    }

    public function confirmTransaction(string $uuid, array $parameters): array
    {
        return $this->post('transactions/'.$uuid.'/confirm', $parameters);
    }
}
