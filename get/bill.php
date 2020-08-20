<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\BillHelper;

$billHelper = new BillHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['shipping_type'])):
        $billHelper->getAllBillByShippingType($_POST['shipping_type']);
    elseif (isset($_POST['shipping_state'])):
        $billHelper->getAllBillByState($_POST['shipping_state']);
    endif;

    die('{"success":true, "value":'. $billHelper->getStringArray() .'}');

endif;
