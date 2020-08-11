<?php

function __autoload($classname) {
    $filename = "./". $classname .".php";
    include_once($filename);
}

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

$fileUtilityManager = new FileUtilityManager($argv[1]);

$tansactionProccessor = new TransactionProccessor($fileUtilityManager);
$tansactionProccessor->process_transactions();