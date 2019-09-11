<?php


namespace Domain\Account;


use Repo\Concrete\AbstractEntity;

class Account extends AbstractEntity
{

    protected $login;
    protected $apikey;
    protected $secretKey;
    /**
     * @var float
     */
    protected $balance = 0;

    public function toArray():array{
        return get_object_vars($this);
    }

    /**
     * @return float
     */
    public function getBalance(): string
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     * @return Account
     */
    public function setBalance(string $balance): Account
    {
        $this->balance = $balance;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getLogin():string
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     * @return Account
     */
    public function setLogin(string $login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * @param mixed $apikey
     * @return Account
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param mixed $secretKey
     * @return Account
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
        return $this;
    }


}