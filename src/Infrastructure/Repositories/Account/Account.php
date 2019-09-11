<?php

namespace Infrastructure\Repositories\Account;

use Domain\Account\AccountCollection;
use Domain\Account\AccountService;
use Domain\Account\Contracts\AccountRepositoryInterface;
use Infrastructure\Adapters\FileAdapter;

/**
 *
 * Реализация хранилища
 * @package Infrastructure\Repositories\Account
 */
class Account implements AccountRepositoryInterface
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
     * @throws \Infrastructure\Adapters\FileAdapterException
     */
    public function save(\Domain\Account\Account $account): void
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
     * @return \Domain\Account\Account|null
     * @throws \Infrastructure\Adapters\FileAdapterException
     */
    public function findByLogin($login): ?\Domain\Account\Account
    {
        $items = $this->fileAdapter->getAll();
        foreach ($items as $item) {
            if ($login === $item["login"]) {
                return self::build($item);
            }
        }

        return null;
    }


    /**
     * @param array $data
     * @return \Domain\Account\Account
     */
    public static function build(array $data): \Domain\Account\Account
    {
        return
            (new \Domain\Account\Account())
                ->setId($data["id"])
                ->setLogin($data["login"])
                ->setSecretKey($data["secretKey"])
                ->setApikey($data["apikey"]);

    }

}