<?php

namespace TwitterBot\tests;

use PDO;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\YamlDataSet;
use TwitterBot\models\BuyerJump;

class BuyerJumpTest extends TestCase {

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
        return $this->createArrayDataSet([]);
    }

    /**
     * init data for select
     */
    private function initializeInitData() {
        $dataSet = new YamlDataSet(dirname(__FILE__) . '/files/init_data.yml');
        $this->databaseTester = null;
        $this->getDatabaseTester()->setSetUpOperation($this->getSetUpOperation());
        $this->getDatabaseTester()->setDataSet($dataSet);
        $this->getDatabaseTester()->onSetUp();
    }

    /**
     * init data for insert
     */
    private function initializeMinimumData() {
        $dataSet = new YamlDataSet(dirname(__FILE__) . '/files/buyer_jump.yml');
        $this->databaseTester = null;
        $this->getDatabaseTester()->setSetUpOperation($this->getSetUpOperation());
        $this->getDatabaseTester()->setDataSet($dataSet);
        $this->getDatabaseTester()->onSetUp();
    }

    public function testSelectNextBuyersJumps() {
        // initialize table
        $this->initializeInitData();

        $buyerJump = new BuyerJump(self::$pdo);
        $nextReleaseDay = '2017-09-11';
        $actual = $buyerJump->selectNextBuyersJumps($nextReleaseDay);

        $expected = $this->getExpectedResults();

        // check record count
        $this->assertEquals(count($expected), count($actual));

        // check records
        $this->assertArraySubset($expected, $actual);

    }

    public function testInsert_success() {
        // initialize
        $this->initializeMinimumData();

        $buyerJump = new BuyerJump();
        $buyerId = 1;
        $jumpId = 1;
        $bought = false;

        $buyerJump->insert($buyerId, $jumpId, $bought);

        // check row count
        $this->assertEquals(1, $this->getConnection()->getRowCount('buyer_jump'));

        // check record
        $dataSet = $this->createArrayDataSet($this->getExpectedDataSet());
        $expectedTable = $dataSet->getTable('buyer_jump');
        $queryTable = $this->getConnection()->createQueryTable(
            'buyer_jump', 'select buyer_id, jump_id, bought from buyer_jump'
        );
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    private function getExpectedResults(): array {
        $expected = [
            [
                'name' => 'user',
                'buyer_id' => 1,
                'jump_id' => 1,
                'bought' => 1,
                'release_day' => '2017-09-11',
                'price' => 250,
                'combined_issue' => 0
            ]
        ];

        return $expected;
    }

    private function getExpectedDataSet(): array {
        return [
            'buyers' => [
                ['id' => 1, 'name' => 'user']
            ],
            'jumps' => [
                ['id' => 1, 'release_day' => '2017-12-25', 'price' => 270, 'combined_issue' => 1]
            ],
            'buyer_jump' => [
                ['buyer_id' => 1, 'jump_id' => 1, 'bought' => 0]
            ]
        ];
    }
}
