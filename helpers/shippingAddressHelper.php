<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

namespace helpers;

use models\ShippingAddress;
use PDOException;

/**
 * Class ShippingAddressHelper
 * @package helpers
 */
class ShippingAddressHelper
{
    public const QUERY = "SELECT ship.ref_adresse_livraison as ship_ref, ship.nom_complet as ship_username, 
                            ship.telephone as ship_phone, ship.ville as ship_district, ship.localite as ship_street, 
                            ship.description_adresse as ship_desc_add, ship.par_defaut as ship_is_default 
                          FROM adresses_livraisons ship";

    /**
     * ShippingAddressHelper constructor.
     */
    public function __construct(){ $this->shippingAddress = new ShippingAddress(); }

    /**
     * @return ShippingAddress
     */
    public function getShippingAddress(): ShippingAddress
    {
        return $this->shippingAddress;
    }

    /**
     * @param ShippingAddress $shippingAddress
     */
    public function setShippingAddress(ShippingAddress $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * Fonction qui permet de récuperer une adresse de livraison en fonction de sa reference.
     * @param string $ref
     */
    public function getShippingAddressByRef(string $ref) {
        try {
            $sql = self::QUERY . " WHERE ref_adresse_livraison = :ref;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute(array(':ref' => $ref));

            $sad = $query->fetchAll();
            foreach ($sad as $result):
                $this->shippingAddress->setData($result->ship_ref, $result->ship_username,
                    $result->ship_phone, $result->ship_district, $result->ship_street, $result->ship_desc_add, $result->ship_is_default);
            endforeach;
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }
    /**
     * Fonction qui permet de récuperer l'adresse de livraison d'un client.
     * @param int $id_client
     */
    public function getClientShippingAddress(int $id_client) {
        try {
            $sql = self::QUERY . " WHERE id_client = :id_client;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute(array(':id_client' => $id_client));

            $sad = $query->fetchAll();
            foreach ($sad as $result):
                $this->shippingAddress->setData($result->ship_ref, $result->ship_username,
                    $result->ship_phone, $result->ship_district, $result->ship_street, $result->ship_desc_add, $result->ship_is_default);
            endforeach;
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui pemret de verifirer si un client possède une address de livraison.
     * @param int $id_client
     */
    public function hasShippingAddress ($id_client) {
        try {
            $sql = "SELECT * FROM adresses_livraisons WHERE id_client = :id_client;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute(array(':id_client' => $id_client));

            $response = array (
                "success" => true,
                "value" => count($query->fetchAll()) !== 0
            );
            die(json_encode($response));
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }
    
    /**
     * Fonction qui permet de convertir un ShippingAddress en json.
     * @return string
     */
    public function getJsonForm() {
        return json_encode($this->shippingAddress, JSON_THROW_ON_ERROR);
    }

    /**
     * @param ShippingAddress $shippingAddress
     * @param $user_id
     * @return string id of the last insertion.
     */
    public function addShippingAddress(ShippingAddress $shippingAddress, $user_id): string
    {
        try{
            $sql = "INSERT INTO adresses_livraisons (ref_adresse_livraison, id_client, nom_complet, telephone, ville, 
                        localite, description_adresse, par_defaut)
                    VALUES (:ship_ref, :user_id, :username, :phone, :district, :street, :add_desc, :is_default);";
            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            $query->execute([':ship_ref' => $this->generateShippingAddRef(), ':user_id' => $user_id,
                ':username' =>$shippingAddress->getReceiverName(), ':phone' =>$shippingAddress->getPhoneNumber(),
                ':district' => $shippingAddress->getDistrict(), ':street' =>$shippingAddress->getStreet(),
                ':add_desc' => $shippingAddress->getMoreDescription(), ':is_default' =>$shippingAddress->isIsDefault()]);
            return $this->shipping_add_ref;
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de génerer la réference d'une facture.
     * @return string
     */
    private function generateShippingAddRef(): string {
        $ref = 'S';
        $ref .= round(microtime(true) * 1000);
        $this->shipping_add_ref = $ref;
        return $this->shipping_add_ref;
    }

    /**
     * @param string $ship_add_ref
     * @return bool
     */
    public function deleteCommend(string $ship_add_ref): bool
    {
        try {
            $sql = "DELETE FROM adresses_livraisons WHERE ref_adresse_livraison = :ship_add_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute(array(':ship_add_ref' => $ship_add_ref));
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * @param string $username
     * @param string $shipping_ref
     * @return bool
     */
    public function updateUsername(string $username, string $shipping_ref): bool
    {
        try {
            $sql = "UPDATE adresses_livraisons SET nom_complet = :username WHERE ref_adresse_livraison = :ship_add_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute(array(':username' => $username, ':ship_add_ref' => $shipping_ref));
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * @param string $phone
     * @param string $shipping_ref
     * @return bool
     */
    public function updatePhone(string $phone, string $shipping_ref)
    {
        try {
            $sql = "UPDATE adresses_livraisons SET telephone = :phone WHERE ref_adresse_livraison = :ship_add_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute(array(':phone' => $phone, ':ship_add_ref' => $shipping_ref));
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * @param string $district
     * @param string $shipping_ref
     * @return bool
     */
    public function updateDistrict(string $district, string $shipping_ref)
    {
        try {
            $sql = "UPDATE adresses_livraisons SET ville = :district WHERE ref_adresse_livraison = :ship_add_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute(array(':district' => $district, ':ship_add_ref' => $shipping_ref));
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * @param string $street
     * @param string $shipping_ref
     * @return bool
     */
    public function updateStreet(string $street, string $shipping_ref)
    {
        try {
            $sql = "UPDATE adresses_livraisons SET localite = :street WHERE ref_adresse_livraison = :ship_add_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute(array(':street' => $street, ':ship_add_ref' => $shipping_ref));
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * @param string $add_desc
     * @param string $shipping_ref
     * @return bool
     */
    public function updateAddDesc(string $add_desc, string $shipping_ref)
    {
        try {
            $sql = "UPDATE adresses_livraisons SET description_adresse = :add_desc WHERE ref_adresse_livraison = :ship_add_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute(array(':add_desc' => $add_desc, ':ship_add_ref' => $shipping_ref));
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * @param int $is_default
     * @param string $shipping_ref
     * @return bool
     */
    public function setAsDefault(int $is_default, string $shipping_ref)
    {
        try {
            $sql = "UPDATE adresses_livraisons SET par_defaut = :is_default WHERE ref_adresse_livraison = :ship_add_ref;";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute(array(':is_default' => $is_default, ':ship_add_ref' => $shipping_ref));
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

}