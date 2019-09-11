<?php


namespace Domain\Rate;


use Domain\Account\Account;
use Repo\Concrete\AbstractEntity;

class Rate extends AbstractEntity
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
        $data["datetime"]   = $this->datetime->getTimestamp();
        $data["account"]    = $this->account->getLogin();
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
     * @return Rate
     */
    public function setRate(float $rate): Rate
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
     * @return Rate
     */
    public function setDatetime(\DateTime $datetime): Rate
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
     * @return Rate
     */
    public function setAccount(Account $account): Rate
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
     * @return Rate
     */
    public function setTarget(string $target): Rate
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
     * @return Rate
     */
    public function setMeasure(string $measure): Rate
    {
        $this->measure = $measure;
        return $this;
    }

}