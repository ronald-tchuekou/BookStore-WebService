<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\ShippingAddressHelper;

$shippingAddressHelper = new ShippingAddressHelper();

if (isset($_POST) && !empty($_POST)) {
    if (isset($_POST['username'], $_POST['shipping_ref']))
        die(json_encode(array(
            'success' => true,
            'value' => $shippingAddressHelper->updateUsername($_POST['username'], $_POST['shipping_ref'])
        )));
    elseif (isset($_POST['phone'], $_POST['shipping_ref']))
        die(json_encode(array(
            'success' => true,
            'value' => $shippingAddressHelper->updatePhone($_POST['phone'], $_POST['shipping_ref'])
        )));
    elseif (isset($_POST['district'], $_POST['shipping_ref']))
        die(json_encode(array(
            'success' => true,
            'value' => $shippingAddressHelper->updateDistrict($_POST['district'], $_POST['shipping_ref'])
        )));
    elseif (isset($_POST['street'], $_POST['shipping_ref']))
        die(json_encode(array(
            'success' => true,
            'value' => $shippingAddressHelper->updateStreet($_POST['street'], $_POST['shipping_ref'])
        )));
    elseif (isset($_POST['add_desc'], $_POST['shipping_ref']))
        die(json_encode(array(
            'success' => true,
            'value' => $shippingAddressHelper->updateAddDesc($_POST['add_desc'], $_POST['shipping_ref'])
        )));
    elseif (isset($_POST['is_default'], $_POST['shipping_ref']))
        die(json_encode(array(
            'success' => true,
            'value' => $shippingAddressHelper->setAsDefault($_POST['is_default'], $_POST['shipping_ref'])
        )));
}