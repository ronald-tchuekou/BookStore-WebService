<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

use helpers\CommendHelper;

require_once 'vendor/autoload.php';

$ref = 'F';
$ref .= $milliseconds = round(microtime(true) * 1000);

//try {
//    $date = new DateTime('now', new DateTimeZone('Africa/Douala'));
//    $date->add(new DateInterval('PT24H'));
//    var_dump($date->format('Y-m-d H:i:s'));
//} catch (Exception $e) {
//    die($e->getMessage());
//}

echo hash('md2', '123456');
echo ' \\ ';
echo hash('md2', '1234');
echo ' \\ ';
echo hash('md2', 'Ronald');
