<?php

namespace TwitterBot\tests;

use PDO;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\YamlDataSet;
use TwitterBot\models\Jumps;

class JumpsTest extends TestCase {

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
        return new YamlDataSet(dirname(__FILE__).'/files/tables.yml');
    }

    public function testInsert() {

        $jumps = new Jumps(self::$pdo);
        $releaseDay = date('Y-m-d', mktime(0, 0, 0, 12, 12, 2017));
        $price = 260;
        $combinedIssue = false;

        // execute
        $jumps->insert($releaseDay, $price, $combinedIssue);

        // check row count
        $this->assertEquals(1, $this->getConnection()->getRowCount("jumps"));

        // check record
        $dataSet= new YamlDataSet(dirname(__FILE__).'/files/jumps.yml');
        $expectedTable = $dataSet->getTable('jumps');
        $queryTable = $this->getConnection()->createQueryTable(
            'jumps', 'select release_day, price, combined_issue from jumps'
        );
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
