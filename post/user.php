<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */
/*
 * The post information is: name(string), surname(string), phone(string), login(string), pass(string)
 */
namespace post;

require_once '../vendor/autoload.php';

use Exception;
use helpers\UserHelper;
use models\User;

if (isset($_POST) && !empty($_POST)){
    $userHelper = new UserHelper();
    try {
        $added = $userHelper->addUser(new User(
            0, $_POST['name'], $_POST['surname'], $_POST['phone'], $_POST['login'], $_POST['pass'], 0
        ));
        die(json_encode(array(
            'success' => $added,
            'value' => 'User creation'
        )));
    } catch (Exception $e) {
        die(json_encode(array (
            'error' => true,
            'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
        )));
    }
}