<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Actions;

use AcquiroPay\Paymarket\Resources\Transaction;

trait ManagesTransactions
{
    public function getTransactions(): array // todo
    {
        return $this->transformCollection(
            $this->get('admin/transactions')['data'],
            Transaction::class
        );
    }

    public function transaction(string $uuid): Transaction
    {
        return new Transaction($this->get('admin/transactions/' . $uuid)['data']);
    }

    public function createTransaction(array $parameters): array
    {
        return $this->post('transactions', $parameters);
    }

    public function confirmTransaction(string $uuid, array $parameters): array
    {
        return $this->post('transactions/' . $uuid . '/confirm', $parameters);
    }
}


