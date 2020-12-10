<?php


namespace Domain\Currency\CurrencyRate;


use Domain\Account\Account;
use Repo\Concrete\AbstractEntity;

class CurrencyRate extends AbstractEntity
{


    /**
     * @var float
     */
    protected $rate;

    /**
     * @var \DateTime
     */
    protected $datetime;

    /**
     * @var Account
     */
    protected $account;

    /**
     * @var string основная валюта
     */
    protected $target;

    /**
     * @var string кросс валюта
     */
    protected $measure;

    /**
     * @return array
     */
    public function toArray():array{
        $data =  get_object_vars($this);
        $data['datetime']   = $this->datetime->getTimestamp();
        $data['account']    = $this->account->getLogin();
        return $data;
    }



    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return CurrencyRate
     */
    public function setRate(float $rate): CurrencyRate
    {
        $this->rate = $rate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime(): \DateTime
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     * @return CurrencyRate
     */
    public function setDatetime(\DateTime $datetime): CurrencyRate
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     * @return CurrencyRate
     */
    public function setAccount(Account $account): CurrencyRate
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     * @return CurrencyRate
     */
    public function setTarget(string $target): CurrencyRate
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @return string
     */
    public function getMeasure(): string
    {
        return $this->measure;
    }

    /**
     * @param string $measure
     * @return CurrencyRate
     */
    public function setMeasure(string $measure): CurrencyRate
    {
        $this->measure = $measure;
        return $this;
    }

}