<?php

namespace TwitterBot\tests\service;

use PHPUnit\Framework\TestCase;
use TwitterBot\service\NextJumpBuyer;
use TwitterBot\models\BuyerJump;
use TwitterBot\models\Buyers;
use TwitterBot\models\Jumps;

class NextJumpBuyerTest extends TestCase {

    private $nextJumpBuyer;

    public function setUp() {
        $this->nextJumpBuyer = new NextJumpBuyer();
    }

    public function testInsertNextBuyerJump() {
        // create mock
        $buyerJumpMock = $this->createMock(BuyerJump::class);
        $buyerJumpMock->method('selectLastBuyersJumps')->willReturn([
            "buyer_id" => 1,
            "jump_id" => 1,
            "bought" => 1
        ]);
        // expect to call at once
        $buyerJumpMock->expects($this->once())->method('insert');
        $this->nextJumpBuyer->setBuyerJump($buyerJumpMock);

        $buyersMock = $this->createMock(Buyers::class);
        $buyersMock->method('selectNextActiveBuyer')->willReturn([
            "id" => 1,
            "name" => "user"
        ]);
        $this->nextJumpBuyer->setBuyers($buyersMock);

        $jumpsMock = $this->createMock(Jumps::class);
        $jumpsMock->method('selectNextJump')->willReturn([
            "id" => 2,
            "release_day" => "2018-02-11",
            "price" => 260,
            "combined_issue" => 0
        ]);
        $this->nextJumpBuyer->setJumps($jumpsMock);

        // execute
        $this->nextJumpBuyer->insertNextBuyerJump();
    }
}