<?php
define('BASEPATH', realpath(__DIR__ . "/../"));

use Infrastructure\Adapters\FIle\FileAdapter;
use Infrastructure\Repositories\Account;
use Infrastructure\Repositories\Rate;
use spaceonfire\CommandBus\CommandBus;
use spaceonfire\CommandBus\Mapping\MapByStaticList;
use Application\UseCases\Account\CreateAccount\CreateAccountCommand;
use Application\UseCases\Account\CreateAccount\CreateAccountHandler;

include_once BASEPATH . '/vendor/autoload.php';

if (!is_dir(BASEPATH . '/cache/accounts')) {
    mkdir(BASEPATH . '/cache/accounts');
}
if (!is_dir(BASEPATH . '/cache/rates')) {
    mkdir(BASEPATH . '/cache/rates');
}

$container = new \League\Container\Container();
$container->delegate(
    new League\Container\ReflectionContainer
);


//Repositories
$container->share(\Domain\Account\Contracts\AccountRepositoryInterface::class, function () {
    return new Account(
        new FileAdapter(BASEPATH . '/cache/accounts')
    );
});
$container->share(\Domain\Rate\Contracts\RateRepositoryInterface::class, function () {
    return new Rate(
        new  FileAdapter(BASEPATH . '/cache/rates')
    );
});

//Command Bus
$this->getContainer()->share(CommandBus::class, function () {
    return new CommandBus(new MapByStaticList([

        CreateAccountCommand::class => CreateAccountHandler::class

    ]), [], $container);
});