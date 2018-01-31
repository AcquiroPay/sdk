<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Resources;


class AbstractResource
{
    /** @var array */
    public $attributes = [];

    /**
     * @param  array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;

        $this->fill($this->attributes);
    }

    protected function fill(array $attributes): void
    {
        foreach ($attributes as $key => $value) {

            $key = $this->camelCase((string)$key);

            $this->{$key} = $value;

        }

    }

    protected function camelCase(string $key): string
    {
        $parts = explode('_', $key);

        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $parts[$i] = ucfirst($part);
            }
        }

        return str_replace(' ', '', implode(' ', $parts));
    }
}