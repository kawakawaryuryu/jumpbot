<?php

namespace TwitterBot\tests;

use PHPUnit\DbUnit\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PDO;

class BaseTestClass extends TestCase {

    use TestCaseTrait;

    protected static $pdo = null;
    protected $connection = null;

    public function getConnection() {
        if ($this->connection == null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
            }
            $this->connection = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_NAME']);
        }

        return $this->connection;
    }

    public function getDataSet() {
        return new YamlDataSet(dirname(__FILE__) .'/files/tables.yml');
    }
}
