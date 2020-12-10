<?php


namespace Infrastructure\Repositories;


use Domain\Account\Account;
use Domain\Account\AccountService;
use Domain\Account\Contracts\AccountRepositoryInterface;
use Repo\CollectionInterface;
use Repo\EntityInterface;
use Repo\PaginationInterface;

class AccountFake implements AccountRepositoryInterface
{
    public function save(EntityInterface $account): void
    {
        // TODO: Implement save() method.
    }

    public function findByLogin($login): ?Account
    {
        // TODO: Implement findByLogin() method.
    }

    public function updateBalance(Account $account): void
    {
        // TODO: Implement updateBalance() method.
    }

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