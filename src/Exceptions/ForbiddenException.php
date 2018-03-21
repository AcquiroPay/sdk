<?php

declare(strict_types=1);

namespace AcquiroPay\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    public function __construct(string $message = 'Seems like you don\'t have permission.')
    {
        parent::__construct($message);
    }
}
