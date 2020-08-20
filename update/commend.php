<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\CommendHelper;

$shippingAddressHelper = new CommendHelper();

if (isset($_POST) && !empty($_POST)){
    if (isset($_POST['validate']))
        die(json_encode(array(
            'success' => true,
            'value' => $shippingAddressHelper->validate($_POST['validate'])
        )));
    elseif (isset($_POST['billed'], $_POST['bill_ref']))
        die(json_encode(array(
            'success' => true,
            'value' => $shippingAddressHelper->billed($_POST['billed'], $_POST['bill_ref'])
        )));
    elseif (isset($_POST['new_q'], $_POST['cmd_id'], $_POST['book_prise']))
        die(json_encode(array(
            'success' => true,
            'value' => $shippingAddressHelper->updateQuantity($_POST['new_q'], $_POST['cmd_id'], $_POST['book_prise'])
        )));
}