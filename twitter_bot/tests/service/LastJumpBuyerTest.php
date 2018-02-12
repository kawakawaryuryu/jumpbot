<?php

namespace TwitterBot\tests\service;

use PHPUnit\Framework\TestCase;
use TwitterBot\models\BuyerJump;
use TwitterBot\service\LastJumpBuyer;

class LastJumpBuyerTest extends TestCase {

    private $lastJumpBuyer;

    private $buyerJumpMock;

    public function setUp() {
        $this->lastJumpBuyer = new LastJumpBuyer();
        $this->buyerJumpMock = $this->createMock(BuyerJump::class);
    }

    public function testBoughtJump_noEmptyBuyerJumpInfo() {
        // set mock
        $this->buyerJumpMock->expects($this->once())->method('update');
        $this->lastJumpBuyer->setBuyerJump($this->buyerJumpMock);

        // execute
        $this->lastJumpBuyer->boughtJump([
            "id" => 1,
            "buyer_id" => 1,
            "jump_id" => 1,
            "bought" => 0
        ]);
    }

    public function testBoughtJump_emptyBuyerJumpInfo() {
        // set mock
        $this->buyerJumpMock->expects($this->never())->method('update');
        $this->lastJumpBuyer->setBuyerJump($this->buyerJumpMock);

        // execute
        $this->lastJumpBuyer->boughtJump([]);
    }
}