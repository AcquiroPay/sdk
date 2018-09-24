<?php

declare(strict_types=1);

namespace AcquiroPay\Contracts;

use AcquiroPay\Constants\Language;
use Illuminate\Support\Collection;

abstract class Enum
{
    protected const LABELS = [];
    protected const TRANSLATIONS = [];

    public static function labels(): Collection
    {
        return collect(static::LABELS);
    }

    public static function label($key, $default = null)
    {
        return static::labels()->get($key, $default);
    }

    public static function constants(): Collection
    {
        return static::labels()->keys();
    }

    public static function has($key): bool
    {
        return static::labels()->has($key);
    }

    public static function getKey(string $label): int
    {
        return (int)array_search($label, static::LABELS, true);
    }

    public static function translations(): Collection
    {
        return collect(static::TRANSLATIONS);
    }

    public static function translation(string $language = Language::RUSSIAN)
    {
        return static::translations()->get($language);
    }
}