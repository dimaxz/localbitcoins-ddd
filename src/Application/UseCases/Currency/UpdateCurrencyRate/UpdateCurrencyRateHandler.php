<?php


namespace Application\UseCases\Currency\UpdateCurrencyRate;


use Domain\Account\AccountService;
use Domain\Currency\CurrencyRate\Contracts\RateRepositoryInterface;

class UpdateCurrencyRateHandler
{
    protected $repository;
    protected $accountService;

    /**
     * UpdateCurrencyRateHandler constructor.
     * @param RateRepositoryInterface $repository
     * @param AccountService $accountService
     */
    public function __construct(RateRepositoryInterface $repository, AccountService $accountService)
    {
        $this->repository = $repository;
        $this->accountService = $accountService;
    }

    /**
     * @param UpdateCurrencyRateCommand $command
     */
    public function handle(UpdateCurrencyRateCommand $command): void
    {
        $account = $this->accountService->getAccountByLogin($command->getLogin());

        $this->repository->createRate($account, $command->getTarget(), $command->getMeasure());
    }

}