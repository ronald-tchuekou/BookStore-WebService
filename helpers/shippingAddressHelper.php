<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

namespace helpers;

use models\ShippingAddress;
use PDOException;

require_once 'vendor/autoload.php';

/**
 * Class ShippingAddressHelper
 * @package helpers
 */
class ShippingAddressHelper
{
    /**
     * @var ShippingAddress
     */
    private $shippingAddress;

    public const QUERY = "SELECT ship.ref_adresse_livraison as ship_ref, ship.nom_complet as ship_username, 
                            ship.telephone as ship_phone, ship.ville as ship_district, ship.localite as ship_street, 
                            ship.description_adresse as ship_desc_add, ship.par_defaut as ship_is_default 
                          FROM adresses_livraisons ship";

    /**
     * ShippingAddressHelper constructor.
     */
    public function __construct(){ }

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
                $this->shippingAddress = new ShippingAddress($result->ship_ref, $result->ship_username,
                    $result->ship_phone, $result->ship_district, $result->ship_street, $result->ship_desc_add, $result->ship_is_default);
            endforeach;
        } catch (PDOException $e) {
            $response = array (
                "Error" => true,
                "Message" => "Erreur dans la requete de récuperation d'une adresse de livraison en fonction de sa reference. " . $e->getMessage()
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
                $this->shippingAddress = new ShippingAddress($result->ship_ref, $result->ship_username,
                    $result->ship_phone, $result->ship_district, $result->ship_street, $result->ship_desc_add, $result->ship_is_default);
            endforeach;
        } catch (PDOException $e) {
            $response = array (
                "Error" => true,
                "Message" => "Erreur dans la requete de récuperation d'un livres à partir de l'élément de recherche. " . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui pemret de verifirer si un client possède une address de livraison.
     * @param int $id_client
     * @return string|bool
     */
    public function hasShippingAddress ($id_client) {
        try {
            $sql = "SELECT * FROM adresses_livraisons WHERE id_client = :id_client;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute(array(':id_client' => $id_client));

            $response = array (
                "hasShippingAddress" => count($query->fetchAll()) !== 0
            );
            return json_encode($response);
        } catch (PDOException $e) {
            $response = array (
                "Error" => true,
                "Message" => "Erreur dans la requete qui pemret de verifirer si un client possède une address de livraison. " . $e->getMessage()
            );
            die(json_encode($response));
        }
    }
    /**
     * Fonction qui permet de convertir un ShippingAddress en string.
     * @return string
     */
    public function getStringObject() {
        if ($this->shippingAddress === null)
            return '{}';
        return '{
          "ref": "'. $this->shippingAddress->getRefAdl() .'",
          "receiver_name": "'. $this->shippingAddress->getReceiverName() .'",
          "phone_number": "'. $this->shippingAddress->getPhoneNumber() .'",
          "district": "'. $this->shippingAddress->getDistrict() .'",
          "street": "'. $this->shippingAddress->getStreet() .'",
          "more_desc": "'. $this->shippingAddress->getMoreDescription() .'",
          "is_default": "'. $this->shippingAddress->isIsDefault() .'"
        }';
    }
}