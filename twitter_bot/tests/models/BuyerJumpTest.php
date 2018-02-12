<?php

namespace TwitterBot\tests\models;

use PHPUnit\DbUnit\DataSet\YamlDataSet;
use TwitterBot\models\BuyerJump;
use TwitterBot\models\BuyerJumpEntity;

class BuyerJumpTest extends BaseTestClass {

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
        $dataSet = new YamlDataSet(dirname(__FILE__) . '/files/buyer_jump/buyer_jump.yml');
        $this->databaseTester = null;
        $this->getDatabaseTester()->setSetUpOperation($this->getSetUpOperation());
        $this->getDatabaseTester()->setDataSet($dataSet);
        $this->getDatabaseTester()->onSetUp();
    }

    public function testSelectNextBuyersJumps() {
        // initialize table
        $this->initializeInitData();

        $buyerJump = new BuyerJump(self::$pdo);
        $day = '2017-09-10';
        $actual = $buyerJump->selectNextBuyersJumps($day);

        $expected = $this->getExpectedResults();

        // check records
        $this->assertArraySubset($expected, $actual);

    }

    public function testSelectNextBuyersJumps_noRecords() {
        // initialize table
        $this->initializeInitData();

        $buyerJump = new BuyerJump(self::$pdo);
        $nextReleaseDay = '2017-09-26';
        $actual = $buyerJump->selectNextBuyersJumps($nextReleaseDay);

        // check record count
        $this->assertEquals(0, count($actual));

    }

    public function testSelectLastBuyersJumps() {
        // initialize table
        $this->initializeInitData();

        $buyerJump = new BuyerJump(self::$pdo);
        $day = '2017-09-14';
        $actual = $buyerJump->selectLastBuyersJumps($day);

        $expected = $this->getExpectedResults();

        // check records
        $this->assertArraySubset($expected, $actual);

    }

    public function testSelectLastBuyersJumps_noRecords() {
        // initialize table
        $this->initializeInitData();

        $buyerJump = new BuyerJump(self::$pdo);
        $day = '2017-09-10';
        $actual = $buyerJump->selectLastBuyersJumps($day);

        // check record count
        $this->assertEquals(0, count($actual));

    }

    public function testInsert_success() {
        // initialize
        $this->initializeMinimumData();

        $buyerJump = new BuyerJump(self::$pdo);
        $buyerId = 1;
        $jumpId = 1;
        $bought = false;

        $buyerJump->insert($buyerId, $jumpId, $bought);

        // check row count
        $this->assertEquals(1, $this->getConnection()->getRowCount('buyer_jump'));

        // check record
        $dataSet = $this->createArrayDataSet($this->getExpectedDataSetInsert());
        $expectedTable = $dataSet->getTable('buyer_jump');
        $queryTable = $this->getConnection()->createQueryTable(
            'buyer_jump', 'select buyer_id, jump_id, bought from buyer_jump'
        );
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    public function testUpdate() {
        // initialize
        $this->initializeInitData();

        $buyerJump = new BuyerJump(self::$pdo);
        $id = 3;
        $bought = true;

        $buyerJump->update($id, $bought);

        // check
        $dataSet = $this->createArrayDataSet($this->getExpectedDataSetUpdate());
        $expectedTable = $dataSet->getTable('buyer_jump');
        $queryTable = $this->getConnection()->createQueryTable(
            'buyer_jump', 'select buyer_id, jump_id, bought from buyer_jump'
        );
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    private function getExpectedResults(): array {
        $expected = [
            'name' => 'user',
            'buyer_id' => 1,
            'jump_id' => 1,
            'bought' => 1,
            'release_day' => '2017-09-11',
            'price' => 250,
            'combined_issue' => 0
        ];

        return $expected;
    }

    private function getExpectedDataSetInsert(): array {
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

    private function getExpectedDataSetUpdate(): array {
        return [
            'buyer_jump' => [
                ['buyer_id' => 1, 'jump_id' => 1, 'bought' => 1],
                ['buyer_id' => 2, 'jump_id' => 2, 'bought' => 1],
                ['buyer_id' => 1, 'jump_id' => 3, 'bought' => 1],
            ]
        ];
    }
}
