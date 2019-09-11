<?php

namespace Domain\Account\Contracts;

use Domain\Account\Account;
use Domain\Account\AccountCollection;
use Domain\Account\AccountService;

interface AccountRepositoryInterface
{

    /**
     * @param Account $account
     */
    public function save(Account $account): void;


    /**
     * @param $login
     * @return AccountService|null
     */
    public function findByLogin($login): ?Account;

    /**
     * @param Account $account
     */
    public function updateBalance(Account $account): void ;

}