<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Constants;

use AcquiroPay\Helpers\AbstractConstant;

class TransactionStatus extends AbstractConstant
{
    public const CREATED = 1;
    public const PROCESSING = 2;
    public const COMPLETED = 3;
    public const DECLINED = 4;
    public const CANCELED = 5;
    public const ERROR = 6;
    public const REFUNDED = 7;

    protected const LABELS = [
        self::CREATED => 'Создана',
        self::PROCESSING => 'Обрабатывается',
        self::COMPLETED => 'Подтверждена',
        self::DECLINED => 'Отклонена',
        self::CANCELED => 'Отменена',
        self::ERROR => 'Ошибка',
        self::REFUNDED => 'Возврат',
    ];
}
