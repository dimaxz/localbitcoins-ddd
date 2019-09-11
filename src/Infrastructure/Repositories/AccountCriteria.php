<?php


namespace Infrastructure\Repositories;

use Repo\Concrete\AbstractCriteria;

class AccountCriteria extends AbstractCriteria
{

    /**
     * @return AccountCriteria
     */
    public static function create()
    {
        return new self();
    }


}