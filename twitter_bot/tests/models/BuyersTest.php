<?php

namespace TwitterBot\tests\models;

use PHPUnit\DbUnit\DataSet\YamlDataSet;
use TwitterBot\models\Buyers;
use Exception;

class BuyersTest extends BaseTestClass {

    public function getDataSet() {
        return new YamlDataSet(dirname(__FILE__) .'/files/buyers/buyers.yml');
    }

    /**
     * init no active buyers data for select
     */
    private function initializeNoActiveBuyersData() {
        $dataSet = new YamlDataSet(dirname(__FILE__) . '/files/buyers/buyers_noactive.yml');
        $this->databaseTester = null;
        $this->getDatabaseTester()->setSetUpOperation($this->getSetUpOperation());
        $this->getDatabaseTester()->setDataSet($dataSet);
        $this->getDatabaseTester()->onSetUp();
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

    public function testSelectNextActiveBuyer_normal() {
        $buyers = new Buyers();
        $actual = $buyers->selectNextActiveBuyer(2);

        // check record
        $this->assertEquals("user", $actual["name"]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage No Active Buyers
     */
    public function testSelectNextActiveBuyer_noActive() {
        // initialize table
        $this->initializeNoActiveBuyersData();

        $buyers = new Buyers();
        $buyers->selectNextActiveBuyer(2);
    }

    public function testSelectNextActiveBuyer_buyerIdNull() {
        $buyers = new Buyers();
        $actual = $buyers->selectNextActiveBuyer(null);

        // check record
        $this->assertEquals("user", $actual["name"]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage buyer_id is invalid
     */
    public function testSelectNextActiveBuyer_invalidBuyerId() {
        $buyers = new Buyers();
        $buyers->selectNextActiveBuyer(-1);
    }
}