<?php

namespace Infrastructure\Repositories;

use Domain\Account\AccountCollection;
use Domain\Account\Contracts\AccountCriteriaInterface;
use Domain\Account\Contracts\AccountRepositoryInterface;
use Infrastructure\Adapters\File\FileAdapter;
use Infrastructure\Adapters\Lbitcoin\LbitcoinAdapter;
use Repo\CollectionInterface;
use Repo\Concrete\AbstractCrudRepository;
use Repo\EntityInterface;
use Repo\PaginationInterface;
use QueryBuilder\SearchCriteria;

/**
 *
 * Реализация хранилища
 * @package Infrastructure\Repositories\Account
 */
class Account extends AbstractCrudRepository implements AccountRepositoryInterface
{
    protected $fileAdapter;

    /**
     * Account constructor.
     * @param FileAdapter $fileAdapter
     */
    public function __construct(FileAdapter $fileAdapter)
    {
        $this->fileAdapter = $fileAdapter;
    }


    /**
     * @param \Domain\Account\Account $account
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
     */
    public function save(\Repo\EntityInterface $account): void
    {
        if (!$id = $account->getId()) {
            $key = $this->fileAdapter->insert($account->toArray());
            $account->setId($key);
            $this->fileAdapter->update($account->toArray(), $key);
        } else {
            $this->fileAdapter->update($account->toArray(), $id);
        }
    }

    /**
     * @param $login
     * @return EntityInterface|null
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
     */
    public function findByLogin($login): ?\Domain\Account\Account
    {
        $items = $this->fileAdapter->getAll();
        foreach ($items as $item) {
            if ($login === $item["login"]) {
                return self::buildEntityFromArray($item);
            }
        }

        return null;
    }

    /**
     * @param \Domain\Account\Account $account
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
     * @throws \Infrastructure\Adapters\Lbitcoin\LbitcoinException
     */
    public function updateBalance(\Domain\Account\Account $account): void
    {
        $lBitIcoin = new LbitcoinAdapter($account->getApikey(),$account->getSecretKey());
        $account->setBalance(
            $lBitIcoin->getWalletBalance()
        );
        $this->save($account);
    }

    protected function modifyCriteria(PaginationInterface $criteria, SearchCriteria $dbCriteria)
    {
        // TODO: Implement modifyCriteria() method.
    }

    /**
     * @return EntityInterface
     */
    public static function createEntity(): EntityInterface
    {
       return new \Domain\Account\Account();
    }

    /**
     * @param array $data
     * @return EntityInterface
     */
    public static function buildEntityFromArray(array $data): EntityInterface
    {
        return (new \Domain\Account\Account())
            ->setId($data["id"])
            ->setLogin($data["login"])
            ->setSecretKey($data["secretKey"])
            ->setBalance($data["balance"])
            ->setApikey($data["apikey"]);
    }

    /**
     * @param AccountCriteriaInterface $criteria
     * @return CollectionInterface
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
     */
    public function findByCriteria(PaginationInterface $criteria): CollectionInterface
    {
        $collection = new AccountCollection();

        $items = $this->fileAdapter->getAll();

        uasort($items, function($a, $b) use ($criteria){
            if ($a["id"] == $b["id"]) {
                return 0;
            }
            if($criteria->getSortByid()==="ASC"){
                return ($a["id"] < $b["id"]) ? -1 : 1;
            }
            return ($a["id"] > $b["id"]) ? -1 : 1;
        });

        foreach ($items as $item) {
            $collection->push(
                self::buildEntityFromArray($item)
            );
        }

        return $collection;
    }


}