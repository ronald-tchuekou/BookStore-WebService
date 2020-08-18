<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

namespace utils;

/**
 * Class AppConst
 * @package helpers
 */
class AppConst {

    // Payment types
    public const PAYMENT_AT_SHIPPING = "A la livraison";
    public const PAYMENT_BY_OM = "Orange Money";
    public const PAYMENT_BY_MM = "Mobile Money";

    // Shipping types
    public const SHIPPING_INSTANT = "Instantaneous";
    public const SHIPPING_STANDARD = "Standard";
    public const SHIPPING_EXPRESS = "Express";

    // Shipping costs.
    public const SHIPPING_COST_INSTANT = 500;
    public const SHIPPING_COST_STANDARD = 500;
    public const SHIPPING_COST_EXPRESS = 2000;

    // Bill state
    public const BILL_DELIVER = "Delivered";
    public const BILL_IN_COURSE = "In Course";
    public const BILL_OBSOLETE = "Obsolete";

}