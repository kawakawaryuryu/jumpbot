<?php

namespace TwitterBot\models;

use PDO;

require_once dirname(__FILE__) . '/../config/db.php';

class DBConnection {

    // connector
    protected $db;

    public function __construct($pdo = null, $dsn = '', $user = '', $pass = '') {
        if (!is_null($pdo)) {
            $this->db = $pdo;
        } else {
            if (empty($dsn) || empty($user) || empty($pass)) {
                $dsn = 'mysql:host='.HOST.';dbname='.DATABASE.';port='.PORT;
                $user = USER;
                $pass = PASS;
            }
            $this->db = new PDO($dsn, $user, $pass);
        }
    }
}
