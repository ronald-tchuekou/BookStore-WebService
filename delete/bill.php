<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../helpers/billHelper.php';
require_once '../helpers/commendHelper.php';

$billHelper = new BillHelper();
$commendHelper = new CommendHelper();

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['bill_ref'])) {
        $commends_is_deleted = $commendHelper->deleteCommendByBillRef($_POST['bill_ref']);
        $bill_is_deleted = $billHelper->deleteBill($_POST['bill_ref']);

        die(json_encode(array(
            "success" => true,
            "value" => $commends_is_deleted && $bill_is_deleted
        )));
    }
}