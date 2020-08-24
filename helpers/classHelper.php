<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

/**
 * classHelper.php
 * --------------
 * Fichier qui permet de gérer les classes de la base de données.
 *
 * @author Ronald Tchuekou
 */

namespace helpers;

use models\Classe, PDOException;

/**
 * Class ClassHelper
 * @package helpers
 */
class ClassHelper {
    
    public const QUERY = "SELECT classes.id as class_id, classes.nom as class_name, classes.libelle as class_libel, cycles.nom as cycle 
                    FROM classes INNER JOIN cycles ON classes.id_cycle = cycles.id";

    public function __construct()
    {
        $this->class = new Classe();
    }

    public function getClasses () {
        return $this->classes;
    }

    public function getClass () {
        return $this->class;
    }

    /**
     * Fonction qui permet de récuperer une classe en fonction de son identifiant.
     * @param int $class_id
     */
    public function getClassById (int $class_id) {
        try{
            $sql = self::QUERY . " WHERE classes.id = :class_id;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute([':class_id' => $class_id]);

            $classList = $query->fetchAll();
            if (count($classList) !== 0)
                foreach ($classList as $item) {
                    $this->class->setData($item->class_id, $item->class_name, $item->class_libel, $item->cycle);
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
     * Fonction qui rétourne tous les classes contenu dans la base de données.
     */
    public function getAllClass () {
        try{
            $sql = self::QUERY . " ORDER BY cycles.nom;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute();

            $classList = $query->fetchAll();
            $classes = [];
            foreach ($classList as $item) {
                $c = new Classe();
                $class = $c->setData($item->class_id, $item->class_name, $item->class_libel, $item->cycle);
                array_push($classes, $class);
            }
            $this->classes = $classes;
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
    }

    /**
     * Fonction qui permet de récuperer tous les classes d'un cycle.
     * @param string $cycle.
     */
    public function getAllCycleClass ($cycle) {
        try{
            $sql = self::QUERY . " WHERE cycles.nom LIKE :cycle ORDER BY classes.nom;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute(array(":cycle" => '%'. $cycle .'%'));

            $classList = $query->fetchAll();
            $classes = [];
            foreach ($classList as $item) {
                $c = new Classe();
                $class = $c->setData($item->class_id, $item->class_name, $item->class_libel, $item->cycle);
                array_push($classes, $class);
            }
            $this->classes = $classes;
        }catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die (json_encode($response));
        }
    }

    /**
     * Fonction qui permet de convertir la liste de classes en json.
     * @return string
     */
    public function getJsonForm () {
        return json_encode($this->classes);
    }
}
