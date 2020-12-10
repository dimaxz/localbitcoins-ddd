<?php

namespace Application\Console;

use Application\UseCases\Account\CreateAccount\CreateAccountCommand;
use Application\UseCases\Account\CreateAccount\CreateAccountException;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddAccount extends Command
{

    protected $accountService;
    protected $commandBus;

    /**
     * AddAccount constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
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

        if (!$login = $input->getOption('login')) {
            $output->writeln('login not set');
            return;
        }
        if (!$apikey = $input->getOption('apikey')) {
            $output->writeln('Api key not set');
            return;
        }
        if (!$secretkey = $input->getOption('secretkey')) {
            $output->writeln('Secret key not set');
            return;
        }

        try {
            $this->commandBus->handle(new CreateAccountCommand($login, $apikey, $secretkey));
            $output->writeln('Account create success!');
        } catch (CreateAccountException $ex) {
            $output->writeln('Account not create. ' . $ex->getMessage());
        }
    }
}