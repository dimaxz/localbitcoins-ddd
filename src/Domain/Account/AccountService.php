<?php

namespace Domain\Account;

use Domain\Account\Contracts\AccountRepositoryInterface;
use Domain\Account\Exceptions\AccountException;
use Domain\Rate\Contracts\RateRepositoryInterface;


/**
 * бизнес логика
 * Class AccountService
 * @package Domain\Account
 */
class AccountService
{
    protected $repo;
    protected $rateRepo;

    /**
     * AccountService constructor.
     * @param AccountRepositoryInterface $repo
     */
    public function __construct(AccountRepositoryInterface $repo, RateRepositoryInterface $rateRepo)
    {
        $this->repo = $repo;
        $this->rateRepo = $rateRepo;
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
     * @param int $minutes - лимит в минутах при желании можно указать и больше,0 - бесконечно
     * @throws AccountException
     */
    public function syncBalanceAndRate($login, $minutes = 10)
    {

        if (!$account = $this->repo->findByLogin($login)) {
            throw new AccountException("account not found");
        }

        try {
            $this->process($account, $minutes);

        } catch (\Exception $e) {
            throw new AccountException($e->getMessage());
        }
    }

    /**
     * бесконечный процесс, но с лимитом
     * @param Account $account
     * @param int $minutes лимит в минутах при желании можно указать и больше,0 - бесконечно
     */
    private function process(Account $account, $minutes)
    {

        $fstart = $start = $startBalance = time();

        $limit = 60 * $minutes;//10 min

        $process = true;

        while ($process) {

            //обновление баланса аккаунта 1 раз в 60 сек
            if ((time() - $startBalance) >= 60) {
                $startBalance = time();
                $this->repo->updateBalance($account);
            }

            //создание курсов аккаунта раз в 10 сек
            if ((time() - $start) >= 10) {
                $start = time();
                $this->rateRepo->createRate($account);
            }

            //выходим если слишком долго
            if ($limit > 0 && (time() - $fstart) >= $limit) {
                $process = false;
            }
        }
    }
}