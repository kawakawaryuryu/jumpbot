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
        return new YamlDataSet(dirname(__FILE__) . '/files/init_data.yml');
    }

    public function testSelectNextBuyersJumps() {

        $buyerJump = new BuyerJump(self::$pdo);
        $nextReleaseDay = '2017-09-11';
        $actual = $buyerJump->selectNextBuyersJumps($nextReleaseDay);

        $expected = $this->getExpectedResults();

        // check record count
        $this->assertEquals(count($expected), count($actual));

        // check records
        $this->assertArraySubset($expected, $actual);

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
}
