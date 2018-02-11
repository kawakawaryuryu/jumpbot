<?php

namespace TwitterBot\tests\service;

use PHPUnit\Framework\TestCase;
use TwitterBot\service\NextJumpBuyer;
use TwitterBot\models\BuyerJump;
use TwitterBot\models\Buyers;
use TwitterBot\models\Jumps;

class NextJumpBuyerTest extends TestCase {

    private $nextJumpBuyer;

    private $buyerJumpMock;
    private $buyersMock;
    private $jumpsMock;

    public function setUp() {
        $this->nextJumpBuyer = new NextJumpBuyer();
        $this->buyerJumpMock = $this->createMock(BuyerJump::class);
        $this->buyersMock = $this->createMock(Buyers::class);
        $this->jumpsMock = $this->createMock(Jumps::class);
    }

    public function testInsertNextBuyerJump_normal() {
        // set mock
        $this->buyerJumpMock->method('selectLastBuyersJumps')->willReturn([
            "buyer_id" => 1,
            "jump_id" => 1,
            "bought" => 1
        ]);
        // expect to call at once
        $this->buyerJumpMock->expects($this->once())->method('insert');
        $this->nextJumpBuyer->setBuyerJump($this->buyerJumpMock);

        $this->buyersMock->method('selectNextActiveBuyer')->willReturn([
            "id" => 1,
            "name" => "user"
        ]);
        $this->nextJumpBuyer->setBuyers($this->buyersMock);

        $this->jumpsMock->method('selectNextJump')->willReturn([
            "id" => 2,
            "release_day" => "2018-02-11",
            "price" => 260,
            "combined_issue" => 0
        ]);
        $this->nextJumpBuyer->setJumps($this->jumpsMock);

        // execute
        $this->nextJumpBuyer->insertNextBuyerJump();
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage no jumps
     */
    public function testInsertNextBuyerJump_nextJumpEmpty() {
        // set mock
        $this->buyerJumpMock->method('selectLastBuyersJumps')->willReturn([]);
        $this->buyerJumpMock->expects($this->never())->method('insert');
        $this->nextJumpBuyer->setBuyerJump($this->buyerJumpMock);

        $this->buyersMock->method('selectNextActiveBuyer')->willReturn([
            "id" => 1,
            "name" => "user"
        ]);
        $this->nextJumpBuyer->setBuyers($this->buyersMock);

        $this->jumpsMock->method('selectNextJump')->willReturn([]);
        $this->nextJumpBuyer->setJumps($this->jumpsMock);

        // execute
        $this->nextJumpBuyer->insertNextBuyerJump();
    }
}