<?php

namespace Domain\Account;

use Domain\Account\Contracts\AccountRepositoryInterface;
use Domain\Account\Exceptions\AccountException;
use Domain\Account\Exceptions\AccountNotFoundException;
use Infrastructure\Repositories\AccountCriteria;


/**
 * бизнес логика
 * Class BalanceService
 * @package Domain\Account
 */
class AccountService
{
    protected $repository;
    protected $rateRepo;

    /**
     * AccountService constructor.
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $login
     * @return Account
     */
    public function getAccountByLogin(string $login): Account
    {
        if (!$account = $this->repository->findByLogin($login)) {
            throw new AccountNotFoundException('account not found by login ' . $login);
        }

        return $account;
    }

    /**
     * @param Account $account
     * @return int
     */
    public function create(Account $account): int
    {
        $this->repository->save($account);

        return $account->getId();
    }

}