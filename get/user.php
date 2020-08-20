<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once '../vendor/autoload.php';

use helpers\UserHelper;

$userHelper = new UserHelper();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['user_id'])):
        $userHelper->getUserById($_POST['user_id']);
        die('{"success":true, "value": '. $userHelper->getStringObject() .'}');
    elseif (isset($_POST['login']) && isset($_POST['pass'])):
        $userHelper->userAuth($_POST['login'], '', $_POST['pass']);
    elseif (isset($_POST['phone']) && isset($_POST['pass'])):
        $userHelper->userAuth('', $_POST['phone'], $_POST['pass']);
    endif;

endif;