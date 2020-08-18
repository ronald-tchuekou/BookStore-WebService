<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

namespace helpers;

require_once 'vendor/autoload.php';

use models\Bill;
use PDOException;

/**
 * Class FactureHelper
 * @package helpers
 */
class BillHelper {
    /**
     * @var array
     */
    private $bills;
    /**
     * @var Bill;
     */
    private $bill;
    /**
     * FactureHelper constructor.
     */
    public function __construct() { }

    /**
     * Fonction qui permet de récuprerer tous les factures de même type de livraison.
     * @param string $shippingType
     */
    public function getAllBillByShippingType (string $shippingType) {
        try{
            $sql = "SELECT * FROM factures  WHERE type_livraison = :shippingType;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([":shippingType" => $shippingType]);

            $billList = $query->fetchAll();
            $bills = [];
            foreach ($billList as $item) {

                // Get the user.
                $userHelper = new UserHelper();
                $userHelper->getUserById($item->id_client);
                $user = $userHelper->getUser();

                // Get the shipping address.
                $shippingHelper = new ShippingAddressHelper();
                $shippingHelper->getShippingAddressByRef($item->ref_adresse_livraison);
                $shippingAddress = $shippingHelper->getShippingAddress();

                // Get list of commends
                $commendHelper = new CommendHelper();
                $commendHelper->getCommendsByBillRef($item->ref_facture);
                $commends = $commendHelper->getCommends();

                $this->bill = new Bill($item->ref_facture, $commends, $user, $shippingAddress, $item->date_livraison,
                    $item->etat, $item->net_a_payer, $item->type_livraison, $item->type_payement, $item->frais_livraison);

                array_push($bills, $this->bill);
            }

            $this->bills = $bills;
        }catch (PDOException $e) {
            $response = array(
                "Error" => true,
                "Message" => "Erreur dans la requete de récuperation de tous les factures de même type de livraison. " . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de récuperer tous les factures d'un état (Delivered / Obsolete).
     * @param string $state
     */
    public function getAllBillByState (string $state) {
        try{
            $sql = "SELECT * FROM factures  WHERE etat = :state;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([":state" => $state]);

            $billList = $query->fetchAll();
            $bills = [];
            foreach ($billList as $item) {

                // Get the user.
                $userHelper = new UserHelper();
                $userHelper->getUserById($item->id_client);
                $user = $userHelper->getUser();

                // Get the shipping address.
                $shippingHelper = new ShippingAddressHelper();
                $shippingHelper->getShippingAddressByRef($item->ref_adresse_livraison);
                $shippingAddress = $shippingHelper->getShippingAddress();

                // Get list of commends
                $commendHelper = new CommendHelper();
                $commendHelper->getCommendsByBillRef($item->ref_facture);
                $commends = $commendHelper->getCommends();

                $this->bill = new Bill($item->ref_facture, $commends, $user, $shippingAddress, $item->date_livraison,
                    $item->etat, $item->net_a_payer, $item->type_livraison, $item->type_payement, $item->frais_livraison);

                array_push($bills, $this->bill);
            }

            $this->bills = $bills;
        }catch (PDOException $e) {
            $response = array(
                "Error" => true,
                "Message" => "Erreur dans la requete de récuperation de tous les factures d'un état (Delivered / Obsolete). " . $e->getMessage()
            );
            die(json_encode($response));
        }
    }
    /**
     * Fonction qui permet de convertir une facture en string.
     * @return string
     */
    public function getStringObject () : string {
        if ($this->bill === null)
            return '{}';

        $bill = $this->bill;

        $userHelper = new UserHelper();
        $userHelper->setUser($bill->getUser());

        $shippingAddressHelper = new ShippingAddressHelper();
        $shippingAddressHelper->setShippingAddress($bill->getShippingAddress());

        $commendHelper = new CommendHelper();
        $commendHelper->setCommends($bill->getCommends());

        return '{
                "ref": "' . $bill->getRef() . '",
                "shipping_date": "' . $bill->getShippingDate() .'",
                "shipping_type": "' . $bill->getShippingType() .'",
                "state": "' . $bill->getState() .'",
                "total_prise": ' . $bill->getTotalPrise() .',
                "payment_type": "' . $bill->getPaymentType() . '",
                "shipping_cost": ' . $bill->getShippingCost() .',
                "user": ' . $userHelper->getStringObject() . ',
                "shipping_address": ' . $shippingAddressHelper->getStringObject() . ',
                "commends": ' . $commendHelper->getStringArray() . '
            }';
    }


    /**
     * Fonction qui permet de convertir un tableau de facture en string.
     * @return string
     */
    public function getStringArray() {
        if(empty($this->bills))
            $result = "[]";
        else{
            $result = "[";
            for ($i = 0; $i < count($this->bills); $i ++) {
                $this->bill = $this->bills[$i];
                $result .= $this->getStringObject();
                $result .= $i === count($this->bills)-1 ? '' : ',';
            }
            $result .= "]";
        }
        return $result;
    }
}