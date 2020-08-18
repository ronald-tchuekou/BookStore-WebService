<?php
/**
 * TODO
 *      Tâches à faire pour la recuperation des données dans la database.
 *
 *    TODO  LIVRES:
 *          1. Récuperer un livre en fonction de la classe.
 *          2. Récuperer un livre en fonction de son titre.
 *          3. Récuperer un livre en fonction de son edition.
 *          4. Récuperer un livre en fonction de son auteur.
 *          5. Récuperer tous les livres d'une classe.
 *          5. Récuperer tous les livres d'un cycle.
 *
 *    TODO  CLASSES:
 *          1. Récuperer tous les classes de la base de données.
 *          2. Récuperer tous les classe d'un cycle.
 *
 *    TODO  COMMANDES:
 *          1. Récuperer tous les commandes standards.
 *          2. Récuperer tous les commandes expersses.
 *          3. Récuperer tous les commandes classiques.
 *          4. Récuperer tous les commandes obsoletes.
 *          5. Récuperer tous les commandes livrées.
 *          6. Récuperer une commande en fonction d'un client.
 *          7. Récuperer tous les commandes non délivrées d'un client.
 *          8. Récuperer tous les commandes délivrées d'un client.
 */



// Test de connection à la base de données.

require_once 'connexion.php';

 $con = new Connexion;
//  print_r($con->clientConnexion());
 print_r($con->adminConnexion());
