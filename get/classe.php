<?php

/**
 * Copyright (c) - 2020 by RonCoder
 */

require_once  '../vendor/autoload.php';

use helpers\ClassHelper;

$classHelper = new ClassHelper();
$classHelper->getAllClass();

if (isset($_POST) && !empty($_POST)):

    if (isset($_POST['cycle'])):
        $classHelper->getAllCycleClass($_POST['cycle']);
    endif;

endif;

die('{"success":true, "value":'. $classHelper->getStringArray() .'}');
