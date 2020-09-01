<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../helpers/userHelper.php';

$userHelper = new UserHelper();

if (isset($_POST) && !empty($_POST)) {
    if (isset($_POST['login'], $_POST['user_id']))
        die(json_encode(array(
            'success' => true,
            'value' => $userHelper->updateUserLogin($_POST['login'], $_POST['user_id'])
        )));
    if (isset($_POST['phone'], $_POST['user_id']))
        die(json_encode(array(
            'success' => true,
            'value' => $userHelper->updateUserPhone($_POST['phone'], $_POST['user_id'])
        )));
    if (isset($_POST['pass'], $_POST['user_id']))
        die(json_encode(array(
            'success' => true,
            'value' => $userHelper->updateUserPassword($_POST['pass'], $_POST['user_id'])
        )));
    if (isset($_POST['is_admin'], $_POST['user_id']))
        die(json_encode(array(
            'success' => true,
            'value' => $userHelper->updateUserIsAdmin($_POST['is_admin'], $_POST['user_id'])
        )));
    if (isset($_POST['last_connexion']))
        die(json_encode(array(
            'success' => true,
            'value' => $userHelper->updateLastUserConnexion($_POST['last_connexion'])
        )));
}