<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\ShippingAddressHelper;

$shippingAddressHelper = new ShippingAddressHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['has_sa'])):
        $shippingAddressHelper->hasShippingAddress($_POST['has_sa']);
    elseif (isset($_POST['user_id'])):
        $shippingAddressHelper->getClientShippingAddress($_POST['user_id']);
    elseif (isset($_POST['bill_ref'])):
        $shippingAddressHelper->getShippingAddressByRef($_POST['bill_ref']);
    endif;

    die('{"success":true, "value":'. $shippingAddressHelper->getStringObject() .'}');

endif;