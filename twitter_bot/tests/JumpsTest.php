<?php

namespace TwitterBot\tests;

use PHPUnit\DbUnit\DataSet\YamlDataSet;
use TwitterBot\models\Jumps;

class JumpsTest extends BaseTestClass {

    public function getDataSet() {
        return new YamlDataSet(dirname(__FILE__).'/files/tables.yml');
    }

    /**
     * init data for selecting next jump
     */
    private function initializeJumpData() {
        $dataSet = new YamlDataSet(dirname(__FILE__) . '/files/jumps/jumps.yml');
        $this->databaseTester = null;
        $this->getDatabaseTester()->setSetUpOperation($this->getSetUpOperation());
        $this->getDatabaseTester()->setDataSet($dataSet);
        $this->getDatabaseTester()->onSetUp();
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
        $dataSet= new YamlDataSet(dirname(__FILE__).'/files/jumps/jumps_for_insert.yml');
        $expectedTable = $dataSet->getTable('jumps');
        $queryTable = $this->getConnection()->createQueryTable(
            'jumps', 'select release_day, price, combined_issue from jumps'
        );
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    public function testSelectNextJump() {
        // initialize table
        $this->initializeJumpData();

        $jumps = new Jumps();
        $day = date('Y-m-d', mktime(0, 0, 0, 12, 18, 2017));

        // execute
        $actual = $jumps->selectNextJump($day);

        // check record
        $expected = $this->getExpectedResult();
        $this->assertArraySubset($expected, $actual);
    }

    private function getExpectedResult(): array {
        return [
            'release_day' => '2017-12-19',
            'price' => 250,
            'combined_issue' =>  0
        ];
    }

}
