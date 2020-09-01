<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

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

    /**
     * Fonction qui permet de verifier si un élément est un type de livraison.
     * @param string $query
     * @return bool
     */
    public static function isShippingType (string $query): bool {
        return $query === self::SHIPPING_STANDARD ||
            $query === self::SHIPPING_EXPRESS ||
            $query === self::SHIPPING_INSTANT;
    }

    /**
     * Fonction qui permet de verifier si un élément est un type de paiement.
     * @param string $query
     * @return bool
     */
    public static function isPaymentType (string $query): bool {
        return $query === self::PAYMENT_AT_SHIPPING ||
            $query === self::PAYMENT_BY_MM ||
            $query === self::PAYMENT_BY_OM;
    }

    /**
     * Fonction qui permet de verifier si un élément est un état de facture.
     * @param string $query
     * @return bool
     */
    public static function isBillState (string $query): bool {
        return $query === self::BILL_IN_COURSE ||
            $query === self::BILL_OBSOLETE ||
            $query === self::BILL_DELIVER;
    }
    
    public static function convert_from_latin1_to_utf8_recursively($dat)
       {
          if (is_string($dat)) {
             return utf8_encode($dat);
          } elseif (is_array($dat)) {
             $ret = [];
             foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);
    
             return $ret;
          } elseif (is_object($dat)) {
             foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);
    
             return $dat;
          } else {
             return $dat;
          }
       }
    
}