<?php


namespace Infrastructure\Repositories;

use Repo\Concrete\AbstractCriteria;

class RateCriteria extends AbstractCriteria
{
    public static function create()
    {
        return new self();
    }

}