<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

/**
 * connexion.php
 * ---------------
 * Fichier qui contient la fonction qui permet de communiquer avec la base de données.
 * @author Ronald Tchuekou.
 */

namespace helpers;

require_once ("vendor/autoload.php");

use PDO, PDOException;

/**
 * Class qui permet de gérer la connexion à la base de données.
 */
class Connexion {

    /**
     * @var PDO
     */
    private $db;
    const HOST = 'mysql:host=ty56189-001.dbaas.ovh.net;port=35477;dbname=bookstore';

    /**
     * Fonction qui permet de connecter un client à la base de données.
     * @return PDO
     */
    public function clientConnexion () {
        $user = 'bookstoreClient';
        $pass = 'bookStore2020';
        try {
            $this->db = new PDO (self::HOST, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die('{ "error" => true, "message" => "Error lors de la connexion à la base de données : "' . $e->getMessage() .'"}');
        }
        return $this->db;
    }

    /**
     * Fonction qui permet de connecter un administrateur à la base de données.
     * @return PDO
     */
    public function adminConnexion () {
        $user = 'bookstoreAdmin';
        $pass = 'BkSem3rk1t';
        try {
            $db = new PDO (self::HOST, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die('{"error" => true, "message" => "Error lors de la connexion à la base de données : "' . $e->getMessage() .'"}');
        }
        return $db;
    }

}
