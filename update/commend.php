<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../helpers/commendHelper.php';

$commendHelper = new CommendHelper();

if (isset($_POST) && !empty($_POST)){
    if (isset($_POST['validate']))
        die(json_encode(array(
            'success' => true,
            'value' => $commendHelper->validate($_POST['validate'])
        )));
    elseif (isset($_POST['billed'], $_POST['bill_ref']))
        die(json_encode(array(
            'success' => true,
            'value' => $commendHelper->billed($_POST['billed'], $_POST['bill_ref'])
        )));
    elseif (isset($_POST['new_q'], $_POST['cmd_id'], $_POST['book_prise']))
        die(json_encode(array(
            'success' => true,
            'value' => $commendHelper->updateQuantity($_POST['new_q'], $_POST['cmd_id'], $_POST['book_prise'])
        )));
}