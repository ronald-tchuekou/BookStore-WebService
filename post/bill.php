<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */
/*
 * The post information is: user_id (int), shipping_add_ref(string), shipping_type(string), total_prise(float)
 */
require_once '../vendor/autoload.php';

use helpers\BillHelper;

if (isset($_POST) && !empty($_POST)) {
    $billHelper = new BillHelper();
    try {
        $bill_ref = $billHelper->addBill($_POST['user_id'], $_POST['shipping_add_ref'], $_POST['shipping_type'],
            $_POST['total_prise']);
        die(json_encode(array (
            'success' => true,
            'value' => $bill_ref
        )));
    } catch (Exception $e) {
        die(json_encode(array (
            'error' => true,
            'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
        )));
    }
}