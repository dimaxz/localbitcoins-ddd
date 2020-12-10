<?php

namespace Domain\Account;

use Repo\Concrete\AbstractCollection;

/**
 * Class AccountCollection
 * @package Domain\Account
 */
class AccountCollection extends AbstractCollection
{
    /**
     * @return string
     */
    protected function getEntityClass(): string
    {
        return Account::class;
    }

}