<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\CommendHelper;
use utils\AppConst;

$commendHelper = new CommendHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['id'])):
        $commendHelper->getCommendById($_POST['id']);
        $response = array (
            "success" => true,
            "value" => $commendHelper->getCommend()
        );
    elseif (isset($_POST['user_id'], $_POST['book_id'])):
        $response = array (
            "success" => true,
            "value" => $commendHelper->userCommendedBookById($_POST['user_id'], $_POST['book_id'])
        );
    elseif (isset($_POST['user_id'])):
        $commendHelper->getClientCommends($_POST['user_id']);
        $response = array (
            "success" => true,
            "value" => $commendHelper->getCommends()
        );
    elseif (isset($_POST['bill_ref'])):
        $commendHelper->getCommendsByBillRef($_POST['bill_ref']);
        $response = array (
            "success" => true,
            "value" => $commendHelper->getCommends()
        );
    endif;

    AppConst::convert_from_latin1_to_utf8_recursively($response);
    die(json_encode($response, JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE));

endif;