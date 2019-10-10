<?php
namespace Application\Controllers;

use ActiveTableEngine\Concrete\ColumnTable;
use ActiveTableEngine\DataTableSimple;
use Domain\Account\Account;
use Domain\Account\AccountService;
use Domain\Account\Contracts\AccountRepositoryInterface;
use Domain\Rate\Contracts\RateRepositoryInterface;
use Domain\Rate\Rate;
use Infrastructure\Repositories\AccountCriteria;
use Infrastructure\Repositories\RateCriteria;

class Home
{

    protected $accountRepository;
    protected $rateRepository;

    public function __construct(AccountRepositoryInterface $accountRepository, RateRepositoryInterface $rateRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->rateRepository = $rateRepository;
    }

    /**
     * @return string
     * @throws \ActiveTableEngine\Exceptions\ActionError
     */
    public function index(){

        //--------------------
        $criteria = new AccountCriteria();
        $criteria->setSortById("DESC");

        $table
            = (new DataTableSimple($this->accountRepository,"accounts"))
            ->setSearchCriteria($criteria)
            ->addColumn(
                (new ColumnTable("id","№"))->setSorted(false)
            )
            ->addColumn(
                (new ColumnTable("login","Логин"))->setSorted(false)
            )
            ->addColumn(
                (new ColumnTable("balance","Баланс"))->setSorted(false)
            );

        //--------------------
        $criteria = new RateCriteria();
        $criteria->setSortById("DESC");

        $tableRate
            = (new DataTableSimple($this->rateRepository,"rates"))
            ->setSearchCriteria($criteria)
            ->addColumn(
                (new ColumnTable("id","№"))->setSorted(false)
            )
            ->addColumn(
                (new ColumnTable("datetime","Дата"))->setSorted(false)
                ->setFormat($this,"formatDate")
            )
            ->addColumn(
                (new ColumnTable("account","Логин аккаунта"))
                ->setFormat($this,"formatAccount")
                ->setSorted(false)
            )
            ->addColumn(
                (new ColumnTable("target","Основная валюта"))->setSorted(false)
            )
            ->addColumn(
                (new ColumnTable("measure","Валюта конвертации"))->setSorted(false)
            )
            ->addColumn(
                (new ColumnTable("rate","Курс"))->setSorted(false)
            )
        ;

        return
            "<h2>Аккаунты</h2>" .
            $table->render() .
            "<h2>Курсы</h2>" .
            $tableRate->render();
    }


    /**
     * @param Account $account
     * @return mixed|string
     */
    public function formatAccount(Rate $rate): string{
        return $rate->getAccount()->getLogin();
    }

    /**
     * @param Rate $rate
     * @return string
     */
    public function formatDate(Rate $rate): string{
        return $rate->getDatetime()->format("Y-m-d H:i");
    }
}