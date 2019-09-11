<?php

use Application\Controllers\Home;
use Domain\Account\AccountService;
use Infrastructure\Adapters\FIle\FileAdapter;
use Infrastructure\Repositories\Account;
use Infrastructure\Repositories\Rate;

require_once __DIR__. '/../bootstrap/prepare.php';


$controller = new Home(
    new Account(
        new FileAdapter(BASEPATH . '/cache/accounts')
    ),
    new Rate(
        new FileAdapter(BASEPATH . '/cache/rates')
    )
);

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


