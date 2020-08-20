<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\ShippingAddressHelper;

$shippingAddressHelper = new ShippingAddressHelper();

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['ship_add_ref'])) {
        die(json_encode(array(
            "success" => true,
            "value" => $shippingAddressHelper->deleteCommend($_POST['ship_add_ref'])
        )));
    }
}