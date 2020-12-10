<?php

namespace Domain\Currency\CurrencyRate;

use Repo\Concrete\AbstractCollection;

class CurrencyRateCollection extends AbstractCollection
{
    protected function getEntityClass(): string
    {
       return CurrencyRate::class;
    }

}