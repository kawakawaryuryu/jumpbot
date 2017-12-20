<?php

namespace TwitterBot\tests;

use PHPUnit\DbUnit\DataSet\YamlDataSet;
use PHPUnit\DbUnit\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use TwitterBot\models\Buyers;
use PDO;

class BuyersTest extends TestCase {

    use TestCaseTrait;

    private static $pdo = null;
    private $connection = null;

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
        return new YamlDataSet(dirname(__FILE__) .'/files/buyers.yml');
    }

    public function testSelectActiveBuyers() {
        $buyers = new Buyers();
        $actual = $buyers->selectActiveBuyers();

        // check record count
        $this->assertEquals(2, count($actual));

        // check records
        $this->assertEquals("user", $actual[0]["name"]);
        $this->assertEquals("admin", $actual[1]["name"]);
    }
}