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

use PDO, PDOException;
use utils\AppConfig;

/**
 * Class qui permet de gérer la connexion à la base de données.
 */
class Connexion {
    
    /**
     * Fonction qui permet de connecter un administrateur à la base de données.
     * @return PDO
     */
    public function adminConnexion (): PDO {
        try {
            $db = new PDO (AppConfig::DNS, AppConfig::ADMIN_NAME, AppConfig::ADMIN_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
        return $db;
    }

    /**
     * Fonction qui permet de connecter un client à la base de données.
     * @return PDO
     */
    public function clientConnexion (): PDO {
        try {
            $this->db = new PDO (AppConfig::DNS, AppConfig::USER_NAME, AppConfig::USER_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
        return $this->db;
    }

}
