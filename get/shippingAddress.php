<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\ShippingAddressHelper;
use utils\AppConst;

$shippingAddressHelper = new ShippingAddressHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['has_sa'])):
        $shippingAddressHelper->hasShippingAddress($_POST['has_sa']);
    elseif (isset($_POST['user_id'])):
        $shippingAddressHelper->getClientShippingAddress($_POST['user_id']);
    elseif (isset($_POST['ship_ref'])):
        $shippingAddressHelper->getShippingAddressByRef($_POST['ship_ref']);
    endif;

    $response = array (
        "success" => true,
        "value" => $shippingAddressHelper->getShippingAddress()
    );

    AppConst::convert_from_latin1_to_utf8_recursively($response);
    die(json_encode($response, JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE));

endif;