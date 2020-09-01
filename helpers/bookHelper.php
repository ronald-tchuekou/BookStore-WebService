<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

/**
 * bookHelper.php
 * --------------
 * Fichier qui permet de gérer les livres de la base de données.
 * 
 * @author Ronald Tchuekou
 */

require_once '../models/book.php';
require_once 'connexion.php';

 class BookHelper {

     private const QUERY = "SELECT livres.id as book_id, titre as book_title, auteur as book_author, editeur as book_editor, 
                        img_chemin as book_image, etat_du_livre as book_state, prix_unitaire as book_unit_prise, quantite_en_stock as book_stock_quantity,
                        classes.nom as classe, cycles.nom as cycle 
                    FROM livres 
                    INNER JOIN livres_cycles ON livres_cycles.id_livre = livres.id 
                    INNER JOIN cycles ON livres_cycles.id_cycle = cycles.id 
                    INNER JOIN livres_classes ON livres_classes.id_livre = livres.id 
                    INNER JOIN classes ON livres_classes.id_classe = classes.id";

     /**
      * BookHelper constructor.
      */
     public function __construct(){ $this->book = new Book(); }

     /**
      * @return array
      */
     public function getBooks(): array
     {
         return $this->books;
     }

     /**
      * @return book
      */
     public function getBook(): book
     {
         return $this->book;
     }

     /**
      * @param book $book
      */
     public function setBook(book $book): void
     {
         $this->book = $book;
     }

     /**
      * Fonction qui permet de récuperer un livre en fonction de son identifiant.
      * @param int $book_id
      */
     public function getBookById(int $book_id) {
         try {
             $sql = self::QUERY . " WHERE livres.id = :book_id;";

             $con = new Connexion;
             $db = $con->clientConnexion();
             $request = $db->prepare($sql);
             $request->execute([':book_id' => $book_id]);

             $fetchList = $request->fetchAll();
             if (count($fetchList) > 0)
                 foreach ($fetchList as $item) 
                    $this->book = $this->fetchIt($item);
         } catch (PDOException $e) {
             $response = array (
                 'error' => true,
                 'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
             );
             die(json_encode($response));
         }
     }
     /**
      * Fonction qui retourne un objet Book.
      */
     private function fetchIt($item) {
        $book_id = $item->book_id;
        $book_title = $item->book_title;
        $book_author = $item->book_author === null ? "" : $item->book_author;
        $book_editor = $item->book_editor === null ? "" : $item->book_editor;
        $book_image = $item->book_image === null ? "" : $item->book_image;
        $book_state = $item->book_state;
        $cycle = $item->cycle;
        $classe = $item->classe;
        $book_unit_prise = $item->book_unit_prise;
        $book_stock_quantity = $item->book_stock_quantity;
        $b = new Book();
       return $b->setData($book_id, $book_title, $book_author, $book_editor, $book_image,
            $book_state, $cycle, $classe, $book_unit_prise, $book_stock_quantity);
     }
     /**
      * Function qui permet de récuperer tous les livres de la database.
      */
     public function getAllBooks () {
         try {
             $sql = self::QUERY . " WHERE quantite_en_stock > 0 ORDER BY classes.nom;";

             $con = new Connexion;
             $db = $con->clientConnexion();
             $request = $db->query($sql);

             $fetchList = $request->fetchAll();
             $books = [];
             foreach ($fetchList as $item) {
                 $book = $this->fetchIt($item);
                 array_push($books, $book);
             }
             $this->books = $books;
         } catch (PDOException $e) {
             $response = array (
                 'error' => true,
                 'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
             );
            die(json_encode($response));
         }
     }

     /**
      * Function qui permet de récuperer tous les livres d'une classe.
      * @param String $class classe concernée.
      */
     public function getAllClassBooks ($class) {
        try {
            $sql = self::QUERY . " WHERE classes.nom LIKE :class AND quantite_en_stock > 0 ORDER BY classes.nom;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute(array(':class' => '%' . $class . '%'));

            $fetchList = $query->fetchAll();
            $books = [];
            foreach ($fetchList as $item)
                array_push($books, $this->fetchIt($item));
            
            $this->books = $books;
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
     }
     
     /**
      * Fonction qui permet de récuperer tous les livres d'un cycle.
      * @param String $cycle Cycle. (Secondaire Francophone | Secondary Anglophone | Primaire Francophone | Primary Anglophone | Maternelle Francophone | Nursery Anglophone)
      */
     public function getAllCycleBooks ($cycle) {
        try {
            $sql = self::QUERY . " WHERE cycles.nom LIKE :cycle AND quantite_en_stock > 0 ORDER BY classes.nom;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute(array(':cycle' => '%' . $cycle . '%'));

            $fetchList = $query->fetchAll();
            $books = [];
            foreach ($fetchList as $item)
                array_push($books, $this->fetchIt($item));
            
            $this->books = $books;
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
     }

     /**
      * Fonction qui permet de récuperer un livre en fonction de son : titre, auteur et edition.
      * @param String $element element de recherche.
      */
     public function getBookBySearchQuery ($element) {
        try {
            $sql = self::QUERY . " WHERE (titre LIKE :query OR auteur LIKE :query OR editeur LIKE :query) AND quantite_en_stock > 0
            ORDER BY classes.nom;";

            $con = new Connexion;
            $db = $con->clientConnexion();
            $query = $db->prepare($sql);
            $query->execute(array(':query' => '%' . $element . '%'));

            $fetchList = $query->fetchAll();
            $books = [];
            foreach ($fetchList as $item) 
                array_push($books, $this->fetchIt($item));
            
            $this->books = $books;
        } catch (PDOException $e) {
            $response = array (
                'error' => true,
                'message' => 'Error => ' . __FUNCTION__ . ' : ' . $e->getMessage()
            );
            die(json_encode($response));
        }
     }

     /**
      * Fonction qui permet de convertir la liste de livre en json.
      */
     public function getJsonForm () {
         return json_decode($this->books);
     }
 }
