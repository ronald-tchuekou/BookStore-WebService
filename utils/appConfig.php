<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

/**
 * Class AppConfig
 * @package utils
 * Classe qui permet de configurer la connexion à la base de données ainsi que les utilisateurs.
 */
class AppConfig {

    // Host.
    public const HOST = 'ty56189-001.dbaas.ovh.net';
    // Port.
    public const PORT = '35477';
    // Name of the database.
    public const DB_NAME = 'bookstore';

    // DNS of database connection.
    public const DNS = 'mysql:host='. self::HOST .';port='. self::PORT .';dbname=' . self::DB_NAME;

    // Admin infos.
    public const ADMIN_NAME = 'bookstoreAdmin';
    public const ADMIN_PASS = 'BkSem3rk1t';

    // User infos.
    public const USER_NAME = 'bookstoreClient';
    public const USER_PASS = 'bookStore2020';

}