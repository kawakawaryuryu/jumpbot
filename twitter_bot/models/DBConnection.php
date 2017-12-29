<?php

namespace TwitterBot\models;

use PDO;
use TwitterBot\config\DBConfig;

class DBConnection {

    // connector
    protected $db;

    public function __construct($pdo = null, $dsn = '', $user = '', $pass = '') {
        if (!is_null($pdo)) {
            $this->db = $pdo;
        } else {
            if (empty($dsn) || empty($user) || empty($pass)) {
                $dsn = 'mysql:host='.DBConfig::getHost().';dbname='.DBConfig::getDatabase().';port='.DBConfig::getPort();
                $user = DBConfig::getUser();
                $pass = DBConfig::getPass();
            }
            $this->db = new PDO($dsn, $user, $pass);
        }
    }
}
