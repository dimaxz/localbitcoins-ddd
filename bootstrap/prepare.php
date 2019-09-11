<?php
define('BASEPATH', realpath(__DIR__."/../"));

include_once BASEPATH . "/vendor/autoload.php";

if(!is_dir(BASEPATH . '/cache/accounts')){
    mkdir(BASEPATH . '/cache/accounts');
}
if(!is_dir(BASEPATH . '/cache/rates')){
    mkdir(BASEPATH . '/cache/rates');
}
