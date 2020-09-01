<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../helpers/billHelper.php';

$billHelper = new BillHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['new_state'], $_POST['bill_ref'])):
        die(json_encode(array (
            "success" => true,
            "value" => $billHelper->setState($_POST['bill_ref'], $_POST['new_state'])
        )));
    elseif (isset($_POST['new_tp'], $_POST['bill_ref'])):
        die(json_encode(array (
            "success" => true,
            "value" => $billHelper->updateTotalPrise($_POST['bill_ref'], $_POST['new_tp'])
        )));
    elseif (isset($_POST['ship_type'], $_POST['bill_ref'])):
        die(json_encode(array (
            "success" => true,
            "value" => $billHelper->updateShippingType($_POST['bill_ref'], $_POST['ship_type'])
        )));
    endif;

endif;