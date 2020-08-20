<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\CommendHelper;

$commendHelper = new CommendHelper();

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['cmd_id'])) {
        die(json_encode(array(
            "success" => true,
            "value" => $commendHelper->deleteCommend($_POST['cmd_id'])
        )));
    }
}