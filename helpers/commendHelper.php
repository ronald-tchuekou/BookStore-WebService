<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

/**
 * commendHelper.php
 * -----------------
 * Fichier qui permet de gérer les commandes de la base de données.
 *
 * @author Ronald Tchuekou
 */

namespace helpers;


use models\Commend;
use PDOException;

/**
 * Class CommendHelper
 * @package helpers
 */
class CommendHelper {

    /**
     * @var array
     */
    private $commends;
    /**
     * @var Commend
     */
    private $commend;

    public const QUERY = "SELECT id, ref_facture, id_livre, id_client, quantite_commandee, prix_total, date_commande, 
                                    est_facture, est_validee
                                FROM clients_commandes_livres";

    /**
     * CommendHelper constructor.
     */
    public function __construct() { }

    /**
     * @return array
     */
    public function getCommends(): array
    {
        return $this->commends;
    }

    /**
     * @param array $commends
     */
    public function setCommends(array $commends): void
    {
        $this->commends = $commends;
    }

    /**
     * @return Commend
     */
    public function getCommend(): Commend
    {
        return $this->commend;
    }

    /**
     * @param Commend $commend
     */
    public function setCommend(Commend $commend): void
    {
        $this->commend = $commend;
    }

    /**
     * Fonction qui permet de récuperer une commande en fonction de son identifiant.
     * @param int $cmd_id
     */
    public function getCommendById (int $cmd_id) {
        try{
            $sql = self::QUERY . " WHERE id = :cmd_id;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([':cmd_id' => $cmd_id]);

            $commendList = $query->fetchAll();
            if (count($commendList) !== 0)
                foreach ($commendList as $item) {
                    // get the commend book.
                    $bookHelper = new BookHelper();
                    $bookHelper->getBookById($item->id_livre);
                    $book = $bookHelper->getBook();

                    $this->commend = new Commend($item->id, $book, $item->quantite_commandee, $item->prix_total,
                        $item->date_commande, $item->est_facture, $item->est_validee);
                }
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de récuperer tous les commandes d'une factures.
     * @param string $bill_ref
     */
    public function getCommendsByBillRef (string $bill_ref) {
        try{
            $sql = self::QUERY . " WHERE ref_facture = :bill_ref;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([':bill_ref' => $bill_ref]);

            $commendList = $query->fetchAll();
            $commends = [];
            if (count($commendList) !== 0)
                foreach ($commendList as $item) {
                    // get the commend book.
                    $bookHelper = new BookHelper();
                    $bookHelper->getBookById($item->id_livre);
                    $book = $bookHelper->getBook();

                    $this->commend = new Commend($item->id, $book, $item->quantite_commandee, $item->prix_total,
                        $item->date_commande, $item->est_facture, $item->est_validee);

                    array_push($commends, $this->commend);
                }

            $this->commends = $commends;
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui rétourne tous les commandes contenu dans la base de données.
     */
    public function getAllCommends () {
        try{
            $sql = self::QUERY . ";";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute();

            $commendList = $query->fetchAll();
            $commends = [];
            foreach ($commendList as $item) {
                // get the commend book.
                $bookHelper = new BookHelper();
                $bookHelper->getBookById($item->id_livre);
                $book = $bookHelper->getBook();
                $commend = new Commend($item->id, $book, $item->quantite_commandee, $item->prix_total, $item->date_commande,
                    $item->est_facture, $item->est_validee);
                array_push($commends, $commend);
            }
            $this->commends = $commends;
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }


    /**
     * Fonction qui permet de récuperer tous les commandes d'un client.
     * @param string $id_client Identifiant du client.
     */
    public function getClientCommends (string $id_client) {
        try {
            $sql = self::QUERY . " WHERE id_client = :id_client ORDER BY date_commande DESC;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([":id_client" => $id_client]);

            $commendList = $query->fetchAll();
            $commends = [];
            foreach ($commendList as $item) {
                // get the commend book.
                $bookHelper = new BookHelper();
                $bookHelper->getBookById($item->id_livre);
                $book = $bookHelper->getBook();
                $commend = new Commend($item->id, $book, $item->quantite_commandee, $item->prix_total, $item->date_commande,
                    $item->est_facture, $item->est_validee);
                array_push($commends, $commend);
            }
            $this->commends = $commends;
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet d'ajouter une commande dans la base de données.
     * @param Commend $commend
     * @param int $user_id
     * @return bool
     */
    public function addCommend (Commend  $commend, $user_id) : bool{
        try {
            $sql = "INSERT INTO clients_commandes_livres (id, id_livre, id_client, quantite_commandee, prix_total, 
                        date_commande, est_facture)
                    VALUES (null, :book_id, :user_id, :quantity, :total_prise, :cmd_date, :is_bill);";

            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([":book_id" => $commend->getBook()->getId(), ":user_id" => $user_id,
                ":quantity" => $commend->getQuantity(), ":total_prise" => $commend->getTotalPrise(),
                ":cmd_date" => $commend->getDateCmd(), ":is_bill" => $commend->isIsBilled()]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet d'ajouter une commande à une facture.
     * @param int $cmd_id
     * @param string $bill_ref
     * @return bool
     */
    public function billed (int $cmd_id, string $bill_ref): bool {
        try {
            $sql = "UPDATE clients_commandes_livres SET  ref_facture = :bill_ref, est_facture = 1 WHERE id = :cmd_id;";
            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([":bill_ref" => $bill_ref, ":cmd_id" => $cmd_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de valider une commande.
     * @param int $cmd_id
     * @return bool
     */
    public function validate (int $cmd_id): bool {
        try {
            $sql = "UPDATE clients_commandes_livres SET  est_validee = 1 WHERE id = :cmd_id;";
            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([":cmd_id" => $cmd_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de convertire un objet Commend en string.
     * @return string
     */
    public function getStringObject () : string {
        if ($this->commend === null)
            return '{}';

        $bookHelper = new BookHelper();
        $bookHelper->setBook($this->commend->getBook());

        return '{
                  "id": "' . $this->commend->getId() . '",
                  "book": ' . $bookHelper->getStringObject() . ',
                  "quantity": ' . $this->commend->getQuantity() . ',
                  "total_prise": ' . $this->commend->getTotalPrise() . ',
                  "date_cmd": "' . $this->commend->getDateCmd() . '",
                  "is_billed": ' . $this->commend->isIsBilled() . ',
                  "is_validate": ' . $this->commend->isIsValidate() . '
                }';
    }

    /**
     * Fonction qui permet de convertir un tableau de commandes en string.
     * @return string
     */
    public function getStringArray() {
        if(empty($this->commends))
            $result = "[]";
        else{
            $result = "[";
            for ($i = 0; $i < count($this->commends); $i ++) {
                $this->commend = $this->commends[$i];
                $result .= $this->getStringObject();
                $result .= $i === count($this->commends)-1 ? '' : ',';
            }
            $result .= "]";
        }
        return $result;
    }

    /**
     * Fonction qui permet de mettre à jour la quantité d'une commande.
     * @param int $new_quantity
     * @param int $cmd_id
     * @param $book_prise
     * @return bool
     */
    public function updateQuantity($new_quantity, $cmd_id, $book_prise): bool
    {
        try {
            $sql = "UPDATE clients_commandes_livres SET  quantite_commandee = :new_q, prix_total = :new_tp WHERE id = :cmd_id;";
            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([':new_q'=> $new_quantity, ":new_tp" => ($book_prise * $new_quantity), ":cmd_id" => $cmd_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * @param string $bill_ref
     * @return bool
     */
    public function deleteCommendByBillRef(string $bill_ref): bool
    {
        try {
            $sql = "DELETE FROM clients_commandes_livres WHERE ref_facture = ?;";
            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([$bill_ref]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * @param int $cmd_id
     * @return bool
     */
    public function deleteCommend(int $cmd_id): bool
    {
        try {
            $sql = "DELETE FROM clients_commandes_livres WHERE id = ?;";
            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);
            return $query->execute([$cmd_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }
}

