<?php


namespace Domain\Rate\Contracts;

use Domain\Rate\Rate;
use Repo\CrudRepositoryInterface;
use Repo\EntityInterface;
use Repo\MapperInterface;

interface RateRepositoryInterface extends CrudRepositoryInterface, MapperInterface
{
    /**
     * Сохранение курса
     * @param Rate $rate
     */
    public function save(EntityInterface $rate): void;

    /**
     * Создание курса
     * @param \Domain\Account\Account $account
     * @return mixed
     */
    public function createRate(\Domain\Account\Account $account);
}