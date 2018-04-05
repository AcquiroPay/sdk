<?php

declare(strict_types=1);

namespace AcquiroPay\Paymarket\Resources;

class Service extends AbstractResource
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $name;

    /** @var  int */
    public $minAmount;

    /** @var  int */
    public $maxAmount;

    /** @var ServiceParameter[] */
    public $parameters;

    /** @var  string */
    public $className;

    /** @var  bool */
    public $isActive;

    /** @var  bool */
    public $isActiveForMerchant;

    /** @var string */
    public $createdAt;

    /** @var string */
    public $updatedAt;

    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->isActiveForMerchant = (bool)array_get($attributes, 'pivot.is_active');

        $this->parameters = array_map(function (array $parameterAttributes) {
            return new ServiceParameter($parameterAttributes);
        }, $attributes['parameters'] ?? []);
    }

}