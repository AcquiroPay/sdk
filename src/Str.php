<?php

declare(strict_types=1);

namespace AcquiroPay;

class Str
{
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string $haystack
     * @param  string|array $needles
     *
     * @return bool
     */
    public static function startsWith($haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && 0 === strpos($haystack, (string) $needle)) {
                return true;
            }
        }

        return false;
    }
}
