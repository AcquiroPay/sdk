<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Enums;

use AcquiroPay\Contracts\Enum;
use AcquiroPay\Enums\Language;

class TransactionStatus extends Enum
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

    protected const TRANSLATIONS = [
        Language::RUSSIAN => self::LABELS,
        Language::ENGLISH => [
            self::CREATED => 'Created',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::DECLINED => 'Declined',
            self::CANCELED => 'Canceled',
            self::ERROR => 'Error',
            self::REFUNDED => 'Refunded',
        ],
    ];
}
