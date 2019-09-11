<?php

namespace Domain\Account\Contracts;

use Domain\Account\Account;
use Domain\Account\AccountService;
use Repo\CrudRepositoryInterface;
use Repo\MapperInterface;
use Repo\EntityInterface;

interface AccountRepositoryInterface extends CrudRepositoryInterface, MapperInterface
{

    /**
     * @param Account $account
     */
    public function save(EntityInterface $account): void;


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