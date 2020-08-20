<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

namespace helpers;

use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;
use models\Bill;
use PDOException;
use utils\AppConst;

/**
 * Class BillHelper
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
     * @var string
     */
    private $bill_ref;
    /**
     * BillHelper constructor.
     */
    public function __construct() { }

    /**
     * Fonction qui permet de récuprerer tous les factures de même type de livraison.
     * @param string $shippingType
     */
    public function getAllBillByShippingType (string $shippingType) {
        if (!AppConst::isShippingType($shippingType))
            die(json_encode(array (
                'error' => true,
                'message' => '\''. $shippingType . '\' isn\'t a Shipping type, set one of ( \''.AppConst::SHIPPING_INSTANT .
                    '\', \''. AppConst::SHIPPING_EXPRESS . '\', \''. AppConst::SHIPPING_STANDARD.'\' ).'
            )));

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
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de récuperer tous les factures d'un état (Delivered / Obsolete).
     * @param string $state
     */
    public function getAllBillByState (string $state) {
        if (!AppConst::isBillState($state))
            die(json_encode(array (
                'error' => true,
                'message' => '\''. $state . '\' isn\'t a bill state, set one of ( \''.AppConst::BILL_DELIVER .
                    '\', \''. AppConst::BILL_IN_COURSE . '\', \''. AppConst::BILL_OBSOLETE.'\' ).'
            )));

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
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }


    /**
     * Fonction qui permet d'ajouter une facture dans la base de données
     * @param int $user_id
     * @param string $shipping_add_ref
     * @param string $shipping_type
     * @param float $total_prise
     * @return bool
     */
    public function addBill ($user_id, $shipping_add_ref, $shipping_type, $total_prise) : bool {
        if (!AppConst::isShippingType($shipping_type))
            die(json_encode(array (
                'error' => true,
                'message' => '\''. $shipping_type . '\' isn\'t a Shipping type, set one of ( \''.AppConst::SHIPPING_INSTANT .
                    '\', \''. AppConst::SHIPPING_EXPRESS . '\', \''. AppConst::SHIPPING_STANDARD.'\' ).'
            )));
        try {
            $sql = "INSERT INTO factures (ref_facture, id_client, ref_adresse_livraison, type_payement, type_livraison, 
                        frais_livraison, date_livraison, net_a_payer, etat)
                    VALUES (:bill_ref, :user_id, :shipping_add_ref, :payment_type, :shipping_type, :shipping_cost, 
                    :shipping_date, :total_prise, :state);";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([':bill_ref' => $this->generateBillRef(), ':user_id' => $user_id,
                ':shipping_add_ref' => $shipping_add_ref, ':payment_type' => AppConst::PAYMENT_AT_SHIPPING,
                ':shipping_type' => $shipping_type, ':shipping_cost' => $this->getShippingCost($shipping_type),
                ':shipping_date' => $this->getShippingDate($shipping_type), ':total_prise' => $total_prise,
                ':state' => AppConst::BILL_IN_COURSE]);

        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de modifier l'étate d'une facture.
     * @param string $bill_ref
     * @param string $new_state
     * @return bool
     */
    public function setState (string $bill_ref, string $new_state): bool {
        if (!AppConst::isBillState($new_state))
            die(json_encode(array (
                'error' => true,
                'message' => '\''. $new_state . '\' isn\'t a bill state, set one of ( \''.AppConst::BILL_DELIVER .
                    '\', \''. AppConst::BILL_IN_COURSE . '\', \''. AppConst::BILL_OBSOLETE.'\' ).'
            )));

        try {
            $sql = "UPDATE factures SET etat = :new_state WHERE ref_facture = :bill_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([':new_state' => $new_state, ':bill_ref' => $bill_ref]);

        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
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

    /**
     * Fonction qui permet de génerer la réference d'une facture.
     * @return string
     */
    private function generateBillRef(): string {
        $ref = 'F';
        $ref .= $milliseconds = round(microtime(true) * 1000);
        $this->bill_ref = $ref;
        return $this->bill_ref;
    }

    /**
     * @return string
     */
    public function getBillRef () {
        return $this->bill_ref;
    }

    /**
     * Fonction qui permet de supprimer une facture.
     * @param string $bill_ref
     * @return bool
     */
    public function deleteBill(string $bill_ref): bool {
        try {
            $sql = "DELETE FROM factures WHERE ref_facture = :bill_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute(array(':bill_ref' => $bill_ref));
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de récuprere la date de livraison d'une facture.
     * @param string $shipping_type
     * @return string
     */
    private function getShippingDate(string $shipping_type): string
    {
        try {
            $date = new DateTime('now', new DateTimeZone('Africa/Douala'));

            if ($shipping_type === AppConst::SHIPPING_INSTANT) {
                $date->add(new DateInterval('PT24H'));
            }
            elseif ($shipping_type === AppConst::SHIPPING_EXPRESS) {
                $date->add(new DateInterval('PT3H'));
            }
            elseif ($shipping_type === AppConst::SHIPPING_STANDARD) {
                $date->add(new DateInterval('P2DT'));
            }
            else
                die(json_encode(array (
                    'error' => true,
                    'message' => 'Shipping type isn\'t correct. (' . $shipping_type . ')'
                )));
            return $date->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de récuprere le frais de livraison d'une facture.
     * @param string $shipping_type
     * @return string
     */
    private function getShippingCost(string $shipping_type): string
    {
        if ($shipping_type === AppConst::SHIPPING_INSTANT) {
            $shipping_cost = AppConst::SHIPPING_COST_INSTANT;
        }
        elseif ($shipping_type === AppConst::SHIPPING_EXPRESS) {
            $shipping_cost = AppConst::SHIPPING_COST_EXPRESS;
        }
        elseif ($shipping_type === AppConst::SHIPPING_STANDARD) {
            $shipping_cost = AppConst::SHIPPING_COST_STANDARD;
        }
        else
            die(json_encode(array (
                'error' => true,
                'message' => 'Shipping type isn\'t correct. (' . $shipping_type . ')'
            )));
        return $shipping_cost;
    }

    public function updateTotalPrise(string $bill_ref, float $new_tp)
    {
        try {
            $sql = "UPDATE factures SET net_a_payer = :new_tp WHERE ref_facture = :bill_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([':new_tp' => $new_tp, ':bill_ref' => $bill_ref]);

        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    public function updateShippingType(string $bill_ref, string $shipping_type)
    {
        if (!AppConst::isShippingType($shipping_type))
            die(json_encode(array (
                'error' => true,
                'message' => '\''. $shipping_type . '\' isn\'t a Shipping type, set one of ( \''.AppConst::SHIPPING_INSTANT .
                    '\', \''. AppConst::SHIPPING_EXPRESS . '\', \''. AppConst::SHIPPING_STANDARD.'\' ).'
            )));

        try {
            $sql = "UPDATE factures SET type_livraison = :shipping_type WHERE ref_facture = :bill_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([':shipping_type' => $shipping_type, ':bill_ref' => $bill_ref]);

        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }
}