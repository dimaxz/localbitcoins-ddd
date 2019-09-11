<?php


namespace Infrastructure\Repositories;


use Domain\Account\AccountCollection;
use Domain\Rate\Contracts\RateRepositoryInterface;
use Domain\Rate\RateCollection;
use Infrastructure\Adapters\FIle\FileAdapter;
use Infrastructure\Adapters\Lbitcoin\LbitcoinAdapter;
use QueryBuilder\SearchCriteria;
use Repo\CollectionInterface;
use Repo\Concrete\AbstractCrudRepository;
use Repo\EntityInterface;
use Repo\PaginationInterface;

class Rate extends AbstractCrudRepository implements RateRepositoryInterface
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

    protected function modifyCriteria(PaginationInterface $criteria, SearchCriteria $dbCriteria)
    {
        // TODO: Implement modifyCriteria() method.
    }

    /**
     * @return \Domain\Rate\Rate
     */
    public static function createEntity(): EntityInterface
    {
        return new \Domain\Rate\Rate();
    }

    /**
     * @param array $data
     * @return \Domain\Rate\Rate
     * @throws \Exception
     */
    public static function buildEntityFromArray(array $data): EntityInterface
    {
        return
            (new \Domain\Rate\Rate())
                ->setId($data["id"])
                ->setDatetime(\DateTime::createFromFormat("U", $data["datetime"]))
                ->setRate($data["rate"])
                ->setTarget($data["target"])
                ->setMeasure($data["measure"])
                ->setAccount(
                    (new \Domain\Account\Account())->setLogin($data["account"])
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


    /**
     * @param \Domain\Rate\Rate $rate
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
     * @return \Domain\Rate\Rate
     * @throws \Infrastructure\Adapters\FIle\FileAdapterException
     * @throws \Infrastructure\Adapters\Lbitcoin\LbitcoinException
     */
    public function createRate(\Domain\Account\Account $account): \Domain\Rate\Rate
    {

        $lBitIcoin = new LbitcoinAdapter($account->getApikey(), $account->getSecretKey());

        $rateValue = $lBitIcoin->equation("max(bitstampusd_avg,bitfinexusd_avg)*usd_in_rub");

        $rate = (new \Domain\Rate\Rate())
            ->setRate($rateValue)
            ->setDatetime(new \DateTime())
            ->setTarget("usd")
            ->setMeasure("rub")
            ->setAccount($account);

        $this->save($rate);

        return $rate;
    }

}