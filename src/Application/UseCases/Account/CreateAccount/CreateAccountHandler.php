<?php


namespace Application\UseCases\Account\CreateAccount;


use Domain\Account\Account;
use Domain\Account\AccountService;
use Domain\Account\Contracts\AccountRepositoryInterface;
use Domain\Account\Exceptions\AccountNotFoundException;

class CreateAccountHandler
{
    /**
     * @var AccountRepositoryInterface
     */
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @param CreateAccountCommand $command
     */
    public function handle(CreateAccountCommand $command): void
    {
        $login = $command->getLogin();
        $apiKey = $command->getPublicKey();
        $secretKey = $command->getSecretKey();

        try {
            $this->accountService->getAccountByLogin($login);
            throw new CreateAccountException('account exits, set another login');
        } catch (AccountNotFoundException $ex) {
            //все хорошо, для данного кейса это нормально, идем дальше
        }

        $account = (new Account())
            ->setLogin($login)
            ->setApikey($apiKey)
            ->setSecretKey($secretKey);

        $this->accountService->create($account);
    }

}