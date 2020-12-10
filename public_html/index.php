<?php

use Application\Controllers\Home;


require_once __DIR__. '/../bootstrap/prepare.php';



//$container->share(\League\Tactician\CommandBus::class,function (){
//    return League\Tactician\Setup\QuickStart::create([
//        \Application\UseCases\BalanceService::class => \Application\UseCases\BalanceService::class
//    ]);
//});

$controller = $container->get(Home::class);
//
//$controller = new Home(
//    new Account(
//        new FileAdapter(BASEPATH . '/cache/accounts')
//    ),
//    new Rate(
//        new FileAdapter(BASEPATH . '/cache/rates')
//    )
//    , \League\Tactician\Setup\QuickStart::create($map)
//);

?>
<!DOCTYPE html>
<html>
<head>
    <style>
         table.easy_form td,
         table.easy_form th{
            border: 1px solid #ddd;
             padding: 5px;
        }

    </style>
</head>
<body>
<?=$controller->index();?>
</body>
</html>


