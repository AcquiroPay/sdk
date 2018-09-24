<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Constants;

use AcquiroPay\Constants\Enum;

class InvoiceStatus extends Enum
{
    public const CREATED = 1;
    public const PROCESSING = 2;
    public const COMPLETED = 3;
    public const DECLINED = 4;
    public const CANCELED = 5;
    public const ERROR = 6;
    public const REFUNDED = 7;

    protected const LABELS = [
        self::CREATED => 'Создан',
        self::PROCESSING => 'Обрабатывается',
        self::COMPLETED => 'Подтвержден',
        self::DECLINED => 'Отклонен',
        self::CANCELED => 'Отменен',
        self::ERROR => 'Ошибка',
        self::REFUNDED => 'Возврат',
    ];
}
