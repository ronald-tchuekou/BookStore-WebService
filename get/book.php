<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\BookHelper;

$bookHelper = new BookHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['class'])):
        $bookHelper->getAllClassBooks($_POST['class']);
    elseif (isset($_POST['cycle'])):
        $bookHelper->getAllCycleBooks($_POST['cycle']);
    elseif (isset($_POST['search'])):
        $bookHelper->getBookBySearchQuery($_POST['search']);
    endif;

    die('{"success":true, "value":'. $bookHelper->getStringArray() .'}');

endif;