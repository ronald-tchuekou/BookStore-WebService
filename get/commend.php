<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\CommendHelper;

$commendHelper = new CommendHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['id'])):
        $commendHelper->getCommendById($_POST['id']);
        die('{"success":true, "value":'. $commendHelper->getStringObject() .'}');
    elseif (isset($_POST['user_id'])):
        $commendHelper->getClientCommends($_POST['user_id']);
    elseif (isset($_POST['bill_ref'])):
        $commendHelper->getCommendsByBillRef($_POST['bill_ref']);
    endif;

    die('{"success":true, "value":'. $commendHelper->getStringArray() .'}');

endif;