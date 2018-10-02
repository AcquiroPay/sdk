<?php

declare(strict_types=1);

namespace AcquiroPay\Enums;

use AcquiroPay\Contracts\Enum;

class Language extends Enum
{
    public const RUSSIAN = 'ru';
    public const ENGLISH = 'en';

    protected const LABELS = [
        self::RUSSIAN => 'Русский',
        self::ENGLISH => 'English',
    ];

}