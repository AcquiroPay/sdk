<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Enums;

use AcquiroPay\Contracts\Enum;
use AcquiroPay\Enums\Language;

class TransferStatus extends Enum
{
    public const CREATED = 1;
    public const PROCESSING = 2;
    public const COMPLETED = 3;
    public const DECLINED = 4;
    public const CANCELED = 5;
    public const ERROR = 6;

    protected const LABELS = [
        self::CREATED => 'Создан',
        self::PROCESSING => 'Обрабатывается',
        self::COMPLETED => 'Подтвержден',
        self::DECLINED => 'Отклонен',
        self::CANCELED => 'Отменен',
        self::ERROR => 'Ошибка',
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
        ],
    ];
}
