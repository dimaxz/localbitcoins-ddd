<?php


namespace Domain\Currency\CurrencyRate\Contracts;

use Domain\Currency\CurrencyRate\CurrencyRate;
use Repo\CrudRepositoryInterface;
use Repo\EntityInterface;
use Repo\MapperInterface;

interface RateRepositoryInterface extends CrudRepositoryInterface, MapperInterface
{
    /**
     * @param EntityInterface $rate
     */
    public function save(EntityInterface $rate): void;

    /**
     * @param \Domain\Account\Account $account
     * @param string $target
     * @param string $measure
     * @return Rate
     */
    public function createRate(\Domain\Account\Account $account, string $target, string $measure): CurrencyRate;
}