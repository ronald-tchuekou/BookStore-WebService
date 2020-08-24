<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

namespace helpers;

use DateTime;
use DateTimeZone;
use Exception;
use models\User;
use PDOException;

/**
 * Class UserHelper
 * @package helpers
 */
class UserHelper
{

    public const QUERY = "SELECT id as user_id, nom as user_name, prenom as user_surname, telephone as user_phone, 
                            email as user_email, mot_de_passe as user_pass, est_admin as user_is_admin
                          FROM clients";

    /**
     * User constructor.
     */
    public function __construct() { $this->user = new User(); }

    /**
     * @return User
     */
    public function getUser(): User {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(user $user) {
        $this->user = $user;
    }

    /**
     * Fonction qui permet de récuperer un utilisateur en fonction de son identifiant.
     * @param int $user_id
     */
    public function getUserById($user_id) {
        try{
            $sql = self::QUERY . " WHERE id = :user_id ;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([':user_id' => $user_id]);

            $userList = $query->fetchAll();
            foreach ($userList as $item) {
                $this->user->setData($item->user_id, $item->user_name, $item->user_surname, $item->user_phone, $item->user_email,$item->user_pass, $item->user_is_admin);
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
     * Fonction qui permet d'ajouter un nouveau utilisateur dans la base de données.
     * @param User $user
     * @return string id of the last insertion.
     * @throws Exception
     */
    public function addUser (User $user): string {
        try {
            $sql = "INSERT INTO clients (nom, prenom, telephone, mot_de_passe, date_inscription, email, est_admin)
                    VALUES (?, ?, ?, ?, ?, ?, ?);";
            $date = new DateTime('now', new DateTimeZone('Africa/Douala'));
            $con = new Connexion;
            $db = $con->adminConnexion();
            $query = $db->prepare($sql);

            // Hashing du mode pass.
            $pass = hash('md2', $user->getPassword());

            $query->execute([$user->getName(), $user->getSurname(), $user->getPhone(), $pass,
                $date->format('Y-m-d H:i:s'), $user->getLogin(), $user->getIsAdmin()]);
            return $db->lastInsertId();
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet d'authetifier un utilisateur.
     * @param string $login
     * @param string $phone
     * @param string $password
     * @return false|string
     */
    public function userAuth ($login = '', $phone = '', $password = '') {
        try{
            $sql = "SELECT * FROM clients WHERE (email = :login OR telephone = :phone) AND mot_de_passe = :password ;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([':login' => $login, ':phone' => $phone, ':password' => hash('md2', $password)]);

            $response = array (
                "success" => true,
                "value" => count($query->fetchAll()) !== 0
            );

            die(json_encode($response));
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de convertir un tableau de User en jspn.
     * @return string
     */
    public function getJsonForm() {
        return json_encode($this->user);
    }

    /**
     * Fonction qui permet de supprimer un utilisateur de la base de données.
     * @param int $user_id
     * @return bool
     */
    public function deleteUser (int $user_id): bool {
        try {
            $sql = "DELETE FROM clients WHERE id = ?;";

            $con = new Connexion();
            $db = $con->adminConnexion();
            $request = $db->prepare($sql);
            return $request->execute([$user_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de modifier le login d'un utilisateur.
     * @param string $login
     * @param int $user_id
     * @return bool
     */
    public function updateUserLogin (string $login, int $user_id): bool {
        try{
            $sql = 'UPDATE clients SET email = ? WHERE id = ?;';

            $con = new Connexion();
            $db = $con->adminConnexion();
            $request = $db->prepare($sql);
            return $request->execute([$login, $user_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de modifier le password d'un utilisateur.
     * @param string $pass
     * @param int $user_id
     * @return bool
     */
    public function updateUserPassword (string $pass, int $user_id): bool {
        try{
            $sql = 'UPDATE clients SET mot_de_passe = ? WHERE id = ?;';

            $con = new Connexion();
            $db = $con->adminConnexion();
            $request = $db->prepare($sql);
            return $request->execute([hash('md2', $pass), $user_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de modifier le telephone d'un utilisateur.
     * @param string $phone
     * @param int $user_id
     * @return bool
     */
    public function updateUserPhone (string $phone, int $user_id): bool {
        try{
            $sql = 'UPDATE clients SET telephone = ? WHERE id = ?;';

            $con = new Connexion();
            $db = $con->adminConnexion();
            $request = $db->prepare($sql);
            return $request->execute([$phone, $user_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de modifier le status d'un utilisateur.
     * @param string $is_admin
     * @param int $user_id
     * @return bool
     */
    public function updateUserIsAdmin (string $is_admin, int $user_id): bool {
        try{
            $sql = 'UPDATE clients SET est_admin = ? WHERE id = ?;';

            $con = new Connexion();
            $db = $con->adminConnexion();
            $request = $db->prepare($sql);
            return $request->execute([$is_admin, $user_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de modifier la derniere connexion d'un utilisateur.
     * @param int $user_id
     * @return bool
     */
    public function updateLastUserConnexion (int $user_id): bool {
        try{
            $date = new DateTime('now', new DateTimeZone('Africa/Douala'));
            $sql = 'UPDATE clients SET derniere_connexion = ? WHERE id = ?;';

            $con = new Connexion();
            $db = $con->adminConnexion();
            $request = $db->prepare($sql);
            return $request->execute([$date->format('Y-m-d H:i:s'), $user_id]);
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        } catch (Exception $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }
}