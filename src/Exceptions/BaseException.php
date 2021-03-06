<?php

declare(strict_types=1);

namespace AcquiroPay\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

class BaseException extends Exception
{
    public static function fromGuzzle(RequestException $exception)
    {
        return new static(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );
    }

    public function getResponse(): ?ResponseInterface
    {
        $previous = $this->getPrevious();
        if ($previous instanceof RequestException) {
            return $previous->getResponse();
        }

        return null;
    }
}
