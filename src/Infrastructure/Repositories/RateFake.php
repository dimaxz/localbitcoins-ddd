<?php


namespace Infrastructure\Repositories;


use Domain\Rate\Contracts\RateRepositoryInterface;
use Domain\Rate\Rate;
use Repo\CollectionInterface;
use Repo\EntityInterface;
use Repo\PaginationInterface;

class RateFake implements RateRepositoryInterface
{
    public function delete(\Repo\EntityInterface $entity)
    {
        // TODO: Implement delete() method.
    }

    public static function createEntity(): EntityInterface
    {
        // TODO: Implement createEntity() method.
    }

    public static function buildEntityFromArray(array $row): EntityInterface
    {
        // TODO: Implement buildEntityFromArray() method.
    }

    public function save(EntityInterface $rate): void
    {
        // TODO: Implement save() method.
    }

    public function createRate(\Domain\Account\Account $account)
    {
        // TODO: Implement createRate() method.
    }

    public function findById(int $id): ?EntityInterface
    {
        // TODO: Implement findById() method.
    }

    public function findByCriteria(PaginationInterface $criteria): CollectionInterface
    {
        // TODO: Implement findByCriteria() method.
    }

    public function count(?PaginationInterface $criteria): int
    {
        // TODO: Implement count() method.
    }

}