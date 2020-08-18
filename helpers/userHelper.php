<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

namespace helpers;

use models\User;
use PDOException;

/**
 * Class UserHelper
 * @package helpers
 */
class UserHelper
{
    /**
     * @var User
     */
    private $user;

    public const PROJECTION = "clients.id as user_id, clients.nom as user_name, clients.prenom as user_surname, 
    clients.telephone as user_phone, clients.email as user_email, clients.mot_de_passe as user_pass, clients.est_admin as user_is_admin";

    /**
     * User constructor.
     */
    public function __construct() { }

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
            $sql = "SELECT " . $this::PROJECTION . " FROM clients WHERE id = :user_id ;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([':user_id' => $user_id]);

            $userList = $query->fetchAll();
            foreach ($userList as $item) {
                $this->user = new User($item->user_id, $item->user_name, $item->user_surname, $item->user_phone, $item->user_email,$item->user_pass, $item->user_is_admin);
            }
        }catch (PDOException $e) {
            $response = array (
                "Error" => true,
                "Message" => "Erreur dans la requete de récuperation d'un utilisateur en fonction de son identifiant. " . $e->getMessage()
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
            $sql = "SELECT " . $this::PROJECTION . " FROM clients WHERE (email = :login OR telephone = :phone) AND mot_de_passe = :password ;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([':login' => $login, ':phone' => $phone, ':password' => $password]);

            $response = array (
                "user_exist" => count($query->fetchAll()) !== 0
            );
            return json_encode($response);
        }catch (PDOException $e) {
            $response = array (
                "Error" => true,
                "Message" => "Erreur dans la requete de vérification de l'existance d'un utilisateur. " . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de convertir un tableau de User en string.
     * @return string
     */
    public function getStringObject() {
        if($this->user === null)
            return "{}";
        else {
            return '{
              "id": ' . $this->user->getId() . ',
              "name": "' . $this->user->getName() . '",
              "surname": "' . $this->user->getSurname() . '",
              "phone": "' . $this->user->getPhone() . '",
              "login": "' . $this->user->getLogin() . '",
              "password": "' . $this->user->getPassword() . '",
              "is_admin": ' . $this->user->getIsAdmin() . '
            }';
        }
    }

}