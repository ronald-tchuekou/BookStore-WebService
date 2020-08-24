<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\UserHelper;
use utils\AppConst;

$userHelper = new UserHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['user_id'])):
        $userHelper->getUserById($_POST['user_id']);
        $response = array (
            "success" => true,
            "value" => $userHelper->getUser()
        );
        AppConst::convert_from_latin1_to_utf8_recursively($response);
        die(json_encode($response, JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE));
    elseif (isset($_POST['login']) && isset($_POST['pass'])):
        $userHelper->userAuth($_POST['login'], '', $_POST['pass']);
    elseif (isset($_POST['phone']) && isset($_POST['pass'])):
        $userHelper->userAuth('', $_POST['phone'], $_POST['pass']);
    endif;


endif;