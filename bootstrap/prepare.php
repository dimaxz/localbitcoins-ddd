<?php

include_once BASEPATH . "/vendor/autoload.php";

if(!is_dir(BASEPATH . '/cache/accounts')){
    mkdir(BASEPATH . '/cache/accounts');
}