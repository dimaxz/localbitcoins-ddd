<?php

namespace Infrastructure\Repositories\Account;

use Domain\Account\Contracts\AccountRepositoryInterface;
use Infrastructure\Adapters\File\FileAdapter;
use Infrastructure\Adapters\Lbitcoin\LbitcoinAdapter;

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

    /**
     * @param \Domain\Account\Account $account
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
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
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
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
     * @param \Domain\Account\Account $account
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
     */
    public function updateBalance(\Domain\Account\Account $account): void
    {
        $lBitIcoin = new LbitcoinAdapter($account->getApikey(),$account->getSecretKey());
        $account->setBalance(
            (float)$lBitIcoin->getWalletBalance()
        );
        $this->save($account);
    }

}