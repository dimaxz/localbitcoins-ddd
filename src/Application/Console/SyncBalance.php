<?php


namespace Application\Console;


use Domain\Account\AccountService;
use Domain\Account\Exceptions\AccountException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SyncBalance extends Command
{
    protected $accountService;

    function __construct(AccountService $service)
    {
        $this->accountService = $service;
        parent::__construct();
    }

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

        $login = $input->getOption('login');

        if(!$login){
            $output->writeln("login not set");
            return;
        }

        try{

            $output->writeln("Start process...");

            $this->accountService->syncBalanceAndRate($login);

            $output->writeln("Sync success!");
        }
        catch (AccountException $ex){
            $output->writeln("Error sync. " . $ex->getMessage());
        }

    }
}