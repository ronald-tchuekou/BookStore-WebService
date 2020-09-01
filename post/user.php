<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */
/*
 * The post information is: name(string), surname(string), phone(string), login(string), pass(string)
 */

require_once '../helpers/userHelper.php';

if (isset($_POST) && !empty($_POST)) {
    $userHelper = new UserHelper();
    try {
        $user_id = $userHelper->addUser(new User(
            0, $_POST['name'], $_POST['surname'], $_POST['phone'], $_POST['login'], $_POST['pass'], 0
        ));
        die(json_encode(array(
            'success' => true,
            'value' => $user_id
        )));
    } catch (Exception $e) {
        die(json_encode(array (
            'error' => true,
            'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
        )));
    }
}