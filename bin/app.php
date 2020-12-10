#!/usr/bin/env php
<?php

use Application\Console\AddAccount;
use Application\Console\SyncBalance;
use Domain\Account\AccountService;
use Infrastructure\Adapters\File\FileAdapter;
use Infrastructure\Repositories\Account;
use Infrastructure\Repositories\Rate;
use Symfony\Component\Console\Application;
use Infrastructure\Repositories\AccountFake;
use Infrastructure\Repositories\RateFake;

require_once __DIR__. '/../bootstrap/prepare.php';

if(!class_exists(Application::class)){
    echo 'Please run composer install' . PHP_EOL;
    die(1);
}

$accountService = $container->get(AccountService::class);

$application = new Application();
$application->setDefaultCommand('list');
$application->add($container->get(AddAccount::class));
$application->add($container->get(SyncBalance::class));
$application->run();