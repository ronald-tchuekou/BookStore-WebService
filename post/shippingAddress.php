<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */
/*
 * The post information is: receiver_name(string), phone(string), district(string), street(string), more_desc(string),
 * user_id(int)
 */
require_once '../vendor/autoload.php';

use helpers\ShippingAddressHelper;
use models\ShippingAddress;

if (isset($_POST) && !empty($_POST)){
    $shippingAddressHelper = new ShippingAddressHelper();
    try {
        $shipping_ref = $shippingAddressHelper->addShippingAddress(new ShippingAddress('', $_POST['receiver_name'],
            $_POST['phone'], $_POST['district'], $_POST['street'], $_POST['more_desc'], 1), $_POST['user_id']);
        die(json_encode (array (
            'success' => true,
            'value' => $shipping_ref
        )));
    } catch (Exception $e) {
        die(json_encode(array (
            'error' => true,
            'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
        )));
    }
}