<?php


namespace Application\Controllers;


use Domain\Account\Account;

class AccountController
{
    protected $reqeuest;
    public function __construct(Reqeuest $reqeuest)
    {
        $this->reqeuest = $reqeuest;
    }

    /**
     * Создаем аккаунт
     * @param string $login
     * @param string $publicKey
     * @param string $privateKey
     */
    protected function createAccount(string $login, string $publicKey, string $privateKey): void
    {

        $account = (new Account())
            ->setLogin($login)
            ->setApiKey($publicKey)
            ->setSecretKey($privateKey);

        //..........

    }

    /**
     * Создаем заказ поставщику на основе позиций
     * @param PositionCollection $positionCollection
     */
    protected function createProviderOrder(PositionCollection $positionCollection): void
    {
        foreach ($positionCollection as $position) {
            $refId = $position->getRefId();

            //..........
        }
    }

}