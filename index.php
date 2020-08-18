<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */
require_once("vendor/autoload.php");

use helpers\{bookHelper, commendHelper, classHelper, ShippingAddressHelper, BillHelper, UserHelper};
use utils\AppConst;

$commendHelp = new CommendHelper ();
$bookHelper = new BookHelper ();
$classHelper = new ClassHelper();
$shippingAddressHelper = new ShippingAddressHelper();
$billHelper = new BillHelper();
$userHelper = new UserHelper();

if (isset($_GET)) {
    if (isset($_GET['book'])) {
        $get = $_GET['book'];
        if (isset($_GET['id'])) {
            $bookHelper->getBookById($_GET['id']);
            $result = $bookHelper->getStringObject();
        }else {
            if ($get === '1')
                $bookHelper->getAllBooks();
            elseif ($get === '2')
                $bookHelper->getAllClassBooks('Terminale');
            elseif ($get === '3')
                $bookHelper->getAllCycleBooks('Secondaire Francophone');
            else
                $bookHelper->getBookBySearchQuery('NMI');

            $result = $bookHelper->getStringArray();
        }
    }
    elseif (isset($_GET['class'])) {
        $get = $_GET['class'];
        if (isset($_GET['id'])) {
            $classHelper->getClassById($_GET['id']);
            $result = $classHelper->getStringObject();
        } else {
            if ($get === '1')
                $classHelper->getAllClass();
            elseif ($get === '2')
                $classHelper->getAllCycleClass('Francophone');

            $result = $classHelper->getStringArray();
        }
    }
    elseif(isset($_GET['commend'])) {
        $get = $_GET['commend'];
        if (isset($_GET['id'])) {
            $commendHelp->getCommendById($_GET['id']);
            $result = $commendHelp->getStringObject();
        } else {
            if ($get === '1')
                $commendHelp->getAllCommends();
            else
                $commendHelp->getClientCommends('1');

            $result = $commendHelp->getStringArray();
        }
    }
    elseif(isset($_GET['shippingAddress'])) {
        $get = $_GET['shippingAddress'];
        $shippingAddressHelper->getShippingAddressByRef($get);
        $result = $shippingAddressHelper->getStringObject();
    }
    elseif(isset($_GET['hasShippingAddress'])) {
        $get = $_GET['hasShippingAddress'];
        $result = $shippingAddressHelper->hasShippingAddress($get);
    }
    elseif(isset($_GET['user'])) {
        $get = $_GET['user'];
        $userHelper->getUserById($get);
        $result = $userHelper->getStringObject();
    }
    elseif(isset($_GET['user_exist'])) {
        $get = $_GET['user_exist'];
        $result = $userHelper->userAuth('toto@tata.com', '', '1234');
    }
    elseif(isset($_GET['bill'])) {
        $get = $_GET['bill'];
        if (isset($_GET['state'])) {
            $billHelper->getAllBillByState(AppConst::BILL_IN_COURSE);
            $result = $billHelper->getStringArray();
        } else {
            $billHelper->getAllBillByShippingType(AppConst::SHIPPING_EXPRESS);
            $result = $billHelper->getStringArray();
        }
    }

    echo '<pre>';
    echo $result;
    echo '</pre>';
    ?>

    <script type="application/javascript" defer>
        console.log(<?php echo $result; ?>)
    </script>

    <?php
}
