<?php

namespace Model\Dao;

require_once 'config_db/config.php';

abstract class DbConnection {
    /* @var $pdo \PDO */

    protected static $pdo;

    private function __construct() {
        
    }

    public static function init() {
        try {
            self::$pdo = new \PDO("mysql:host=" . DB_IP . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Problem with db query  - " . $e->getMessage();
        }
    }

    public static function getPdo() {
        if (!self::$pdo) {
            self::init();
        }
        return self::$pdo;
    }
}
