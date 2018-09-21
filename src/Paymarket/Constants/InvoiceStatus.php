<?php

declare(strict_types=1);

namespace App\Constants;

class InvoiceStatus
{
    public const CREATED = 1;
    public const PROCESSING = 2;
    public const COMPLETED = 3;
    public const DECLINED = 4;
    public const CANCELED = 5;
    public const ERROR = 6;
    public const REFUNDED = 7;
}
