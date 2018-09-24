<?php

declare(strict_types=1);

namespace AcquiroPay\Helpers\Constants;

use AcquiroPay\Helpers\AbstractConstant;

class Language extends AbstractConstant
{
    public const RUSSIAN = 'ru';
    public const ENGLISH = 'en';

    protected const LABELS = [
        self::RUSSIAN => 'Русский',
        self::ENGLISH => 'English',
    ];
}