<?php

namespace Application\Console;

use Domain\Account\AccountService;
use Domain\Account\Exceptions\AccountException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddAccount extends Command
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
            ->setName('add-account')
            ->setDescription('Add Account')
            ->setDefinition(
                new InputDefinition(array(
                    new InputOption('login', 'l', InputOption::VALUE_REQUIRED),
                    new InputOption('apikey', 'k', InputOption::VALUE_REQUIRED),
                    new InputOption('secretkey', 's', InputOption::VALUE_REQUIRED)
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
        $apikey = $input->getOption('apikey');
        $secretkey = $input->getOption('secretkey');

        if(!$login){
            $output->writeln("login not set");
            return;
        }

        if(!$apikey){
            $output->writeln("Apikey not set");
            return;
        }

        if(!$secretkey){
            $output->writeln("Secret key not set");
            return;
        }

        try{

            $this->accountService->add($login,$apikey,$secretkey);

            $output->writeln("Acount create success!");
        }
        catch (AccountException $ex){
            $output->writeln("Acount not create. " . $ex->getMessage());
        }

    }
}