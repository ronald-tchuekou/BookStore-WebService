<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../helpers/bookHelper.php';
require_once '../utils/appConst.php';

$bookHelper = new BookHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['class'])):
        $bookHelper->getAllClassBooks($_POST['class']);
    elseif (isset($_POST['cycle'])):
        $bookHelper->getAllCycleBooks($_POST['cycle']);
    elseif (isset($_POST['search'])):
        $bookHelper->getBookBySearchQuery($_POST['search']);
    endif;

    $response = array (
        "success" => true,
        "value" => $bookHelper->getBooks()
    );

    AppConst::convert_from_latin1_to_utf8_recursively($response);
    die(json_encode($response, JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE));

endif;