#!/usr/bin/env php
<?php

use Application\Console\AddAccount;
use Application\Console\SyncBalance;
use Domain\Account\AccountService;
use Infrastructure\Adapters\File\FileAdapter;
use Infrastructure\Repositories\Account\Account;
use Symfony\Component\Console\Application;

define('BASEPATH', realpath(__DIR__."/../"));

require_once BASEPATH.'/bootstrap/prepare.php';


if(!class_exists(Application::class)){
    echo "Please run composer install" . PHP_EOL;
    die(1);
}

$accountService = new AccountService(
    new Account(
        new FileAdapter(BASEPATH . '/cache/accounts')
    )
);

$application = new Application();
$application->setDefaultCommand("list");
$application->add(
        new AddAccount(
                $accountService
        )
);

$application->add(
    new SyncBalance(
        $accountService
    )
);

$application->run();