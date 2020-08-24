<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */
require_once 'vendor/autoload.php';

use helpers\CommendHelper;
use helpers\BookHelper;
use helpers\UserHelper;
use utils\AppConst;

$ref = 'F';
$ref .= $milliseconds = round(microtime(true) * 1000);

//try {
//    $date = new DateTime('now', new DateTimeZone('Africa/Douala'));
//    $date->add(new DateInterval('PT24H'));
//    var_dump($date->format('Y-m-d H:i:s'));
//} catch (Exception $e) {
//    die($e->getMessage());
//}

// echo hash('md2', '123456');
// echo ' \\ ';
// echo hash('md2', '1234');
// echo ' \\ ';
// echo hash('md2', 'Ronald');
$commendHelper = new CommendHelper();

$bookHelper = new BookHelper();
// $bookHelper->getBookById(1);
// $response = array (
//     "success" => true,
//     "value" => $bookHelper->getBook()
// );
// // var_dump($response);
$bookHelper->getBookById(30);
$response = array (
    "success" => true,
    "value" => $bookHelper->getBooks()
);

AppConst::convert_from_latin1_to_utf8_recursively($response);

die(json_encode($response, JSON_THROW_ON_ERROR));

// $commendHelper->getClientCommends($_POST['user_id']);
//         $response = array (
//             "success" => true,
//             "value" => $commendHelper->getCommends()
//         );
