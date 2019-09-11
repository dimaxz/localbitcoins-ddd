<?php

namespace Domain\Account;

use Repo\CollectionInterface;
use Repo\Concrete\AbstractCollection;

/**
 * Class AccountCollection
 * @package Domain\Account
 */
class AccountCollection extends AbstractCollection implements CollectionInterface
{
    protected function getEntityClass(): string
    {
        return Account::class;
    }

}