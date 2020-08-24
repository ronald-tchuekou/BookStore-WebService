<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once  '../vendor/autoload.php';

use helpers\ClassHelper;
use utils\AppConst;

$classHelper = new ClassHelper();
$classHelper->getAllClass();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['cycle'])):
        $classHelper->getAllCycleClass($_POST['cycle']);
    endif;

endif;

$response = array (
    "success"=> true,
    "value" => $classHelper->getClasses()
);

AppConst::convert_from_latin1_to_utf8_recursively($response);
die(json_encode($response, JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE));
