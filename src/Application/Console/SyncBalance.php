<?php


namespace Application\Console;


use Application\UseCases\Account\UpdateBalance\UpdateBalanceCommand;
use Application\UseCases\Currency\UpdateCurrencyRate\UpdateCurrencyRateCommand;
use Domain\Account\AccountService;
use Domain\Account\Exceptions\AccountNotFoundException;
use spaceonfire\CommandBus\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SyncBalance extends Command
{
    protected $accountService;

    protected $commandBus;

    /**
     * SyncBalance constructor.
     * @param AccountService $accountService
     * @param CommandBus $commandBus
     */
    public function __construct(AccountService $accountService, CommandBus $commandBus)
    {
        $this->accountService = $accountService;
        $this->commandBus = $commandBus;
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('sync-balance')
            ->setDescription('Sync Account Balance')
            ->setDefinition(
                new InputDefinition(array(
                    new InputOption('login', 'l', InputOption::VALUE_REQUIRED)
                ))
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {

        if (!$login = $input->getOption('login')) {
            $output->writeln('login not set');
            return;
        }

        try {

            $output->writeln('Start process...');

            $this->syncBalanceAndRate($login);

            $output->writeln('Sync success!');
        } catch (AccountNotFoundException $ex) {
            $output->writeln('Error sync. ' . $ex->getMessage());
        }
    }


    /**
     * БП приложения
     * синхронизация баланса и валют
     * @param $login
     * @param int $minutes - лимит в минутах при желании можно указать и больше,0 - бесконечно
     */
    private function syncBalanceAndRate($login, $minutes = 10): void
    {


        $fstart = $start = $startBalance = time();

        $limit = 60 * $minutes;//10 min

        $process = true;

        while ($process) {

            //обновление баланса аккаунта 1 раз в 60 сек
            if ((time() - $startBalance) >= 60) {
                $startBalance = time();
                $this->commandBus->handle(new UpdateBalanceCommand($login));
            }

            //создание курсов аккаунта раз в 10 сек
            if ((time() - $start) >= 10) {
                $start = time();
                $this->commandBus->handle(new UpdateCurrencyRateCommand($login,'rub','usd'));
            }

            //выходим если слишком долго
            if ($limit > 0 && (time() - $fstart) >= $limit) {
                $process = false;
            }
        }

    }

}