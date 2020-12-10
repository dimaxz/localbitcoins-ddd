<?php


namespace Application\UseCases\Account\UpdateBalance;


use Domain\Account\AccountService;
use Domain\Account\Contracts\AccountRepositoryInterface;

class UpdateBalanceHandler
{

    protected $accountService;
    protected $accountRepository;

    public function __construct(AccountService $accountService, AccountRepositoryInterface $accountRepository)
    {
        $this->accountService = $accountService;
        $this->accountRepository = $accountRepository;
    }

    /**
     * @param UpdateBalanceCommand $command
     */
    public function handle(UpdateBalanceCommand $command): void
    {
        $login = $command->getLogin();
        $account = $this->accountService->getAccountByLogin($login);
        $this->accountRepository->updateBalance($account);
    }
}