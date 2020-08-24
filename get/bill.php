<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\BillHelper;
use utils\AppConst;

$billHelper = new BillHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['shipping_type'])):
        $billHelper->getAllBillByShippingType($_POST['shipping_type']);
    elseif (isset($_POST['shipping_state'])):
        $billHelper->getAllBillByState($_POST['shipping_state']);
    endif;

    $response = array (
        "success" => true,
        "value" => $billHelper->getBills()
    );

    AppConst::convert_from_latin1_to_utf8_recursively($response);
    die(json_encode($response, JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE));


endif;
