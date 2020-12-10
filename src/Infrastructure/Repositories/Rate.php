<?php

namespace Infrastructure\Repositories;


use Domain\Currency\CurrencyRate\Contracts\RateRepositoryInterface;
use Domain\Currency\CurrencyRate\CurrencyRate;

use Infrastructure\Adapters\FIle\FileAdapter;
use Infrastructure\Adapters\Lbitcoin\LbitcoinAdapter;
use Repo\CollectionInterface;
use Repo\EntityInterface;
use Repo\PaginationInterface;

class Rate implements RateRepositoryInterface
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

    public function delete(\Repo\EntityInterface $entity): void
    {
        // TODO: Implement delete() method.
    }

    public function findById(int $id): ?EntityInterface
    {
        // TODO: Implement findById() method.
    }

    public function count(?PaginationInterface $criteria): int
    {
        // TODO: Implement count() method.
    }


    /**
     * @return EntityInterface
     */
    public static function createEntity(): EntityInterface
    {
        return new CurrencyRate();
    }

    /**
     * @param array $data
     * @return EntityInterface
     */
    public static function buildEntityFromArray(array $data): EntityInterface
    {
        return
            (new CurrencyRate())
                ->setId($data['id'])
                ->setDatetime(\DateTime::createFromFormat('U', $data['datetime']))
                ->setRate($data['rate'])
                ->setTarget($data['target'])
                ->setMeasure($data['measure'])
                ->setAccount(
                    (new \Domain\Account\Account())->setLogin($data['account'])
                );
    }

    /**
     * @param PaginationInterface $criteria
     * @return CollectionInterface
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
     */
    public function findByCriteria(PaginationInterface $criteria): CollectionInterface
    {
        $collection = new RateCollection();

        $items = $this->fileAdapter->getAll();

        uasort($items, function ($a, $b) use ($criteria) {
            if ($a['id'] === $b['id']) {
                return 0;
            }
            if ($criteria->getSortByid() === 'ASC') {
                return ($a['id'] < $b['id']) ? -1 : 1;
            }
            return ($a['id'] > $b['id']) ? -1 : 1;
        });

        foreach ($items as $item) {
            $collection->push(
                self::buildEntityFromArray($item)
            );
        }

        return $collection;
    }


    /**
     * @param EntityInterface $rate
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
     */
    public function save(EntityInterface $rate): void
    {
        if (!$id = $rate->getId()) {
            $key = $this->fileAdapter->insert($rate->toArray());
            $rate->setId($key);
            $this->fileAdapter->update($rate->toArray(), $key);
        } else {
            $this->fileAdapter->update($rate->toArray(), $id);
        }
    }

    /**
     * @param \Domain\Account\Account $account
     * @param string $target
     * @param string $measure
     * @return CurrencyRate
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
     * @throws \Infrastructure\Adapters\Lbitcoin\LbitcoinException
     */
    public function createRate(\Domain\Account\Account $account, string $target, string $measure): CurrencyRate
    {

        $lBitIcoin = new LbitcoinAdapter($account->getApikey(), $account->getSecretKey());

        $rateValue = $lBitIcoin->equation('max(bitstampusd_avg,bitfinexusd_avg)*usd_in_rub');

        $rate = (new CurrencyRate())
            ->setRate($rateValue)
            ->setDatetime(new \DateTime())
            ->setTarget($target)
            ->setMeasure($measure)
            ->setAccount($account);

        $this->save($rate);

        return $rate;
    }

}