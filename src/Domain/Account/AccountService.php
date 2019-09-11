<?php

namespace Domain\Account;

use Domain\Account\Contracts\AccountRepositoryInterface;
use Domain\Account\Exceptions\AccountException;



/**
 * бизнес логика
 * Class AccountService
 * @package Domain\Account
 */
class AccountService
{
    protected $repo;

    /**
     * AccountService constructor.
     * @param AccountRepositoryInterface $repo
     */
    public function __construct(AccountRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param $login
     * @param $apikey
     * @param $secretkey
     * @return int
     * @throws AccountException
     */
    public function add($login, $apikey, $secretkey): int
    {

        $account = $this->repo->findByLogin($login);

        if ($account) {
            throw new AccountException("account exits, set another login");
        }

        $account = (new Account())
            ->setLogin($login)
            ->setApikey($apikey)
            ->setSecretKey($secretkey);

        $this->repo->save($account);

        if (empty($account->getId())) {
            throw new AccountException("account not create");
        }

        return $account->getId();
    }


    /**
     * @param $login
     * @throws AccountException
     */
    public function syncBalanceAndRate($login)
    {


        if (!$user = $this->repo->findByLogin($login)) {
            throw new AccountException("account not found");
        }

        try {
            $this->process($user);
        } catch (\Exception $e) {
            throw new AccountException($e->getMessage());
        }
    }

    /**
     * бесконечный процесс
     * @param Account $account
     */
    private function process(Account $account)
    {

        $fstart = $start = time();

        $limit = 60 * 5;//5 min

        $res = true;

        while ($res) {

            $tek = time() - $start;

            if ($tek >= 10) {
                $start = time();
                $this->repo->updateBalance($account);
            }

            //выходим если слишком долго
            if ((time() - $fstart) >= $limit) {
                $res = false;
            }
        }
    }
}