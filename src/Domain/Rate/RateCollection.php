<?php

namespace Domain\Rate;

use Repo\Concrete\AbstractCollection;

class RateCollection extends AbstractCollection
{
    protected function getEntityClass(): string
    {
       return Rate::class;
    }

}