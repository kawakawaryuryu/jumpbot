<?php

namespace TwitterBot\service;

use TwitterBot\models\BuyerJump;
use TwitterBot\models\Buyers;
use TwitterBot\models\Jumps;

class NextJumpBuyer {

    private $buyerJump;

    public function __construct() {
        $this->buyerJump = new BuyerJump();
    }

    private function getLastBuyerId(): int {
        // get last buyer and jump info
        $lastBuyersJumps = $this->buyerJump->selectLastBuyersJumps();
        return $lastBuyersJumps["buyer_id"];
    }

    private function getNextBuyerId(int $lastBuyerId): int {
        // get next buyer
        $buyers = new Buyers();
        $nextBuyer = $buyers->selectNextActiveBuyer($lastBuyerId);

        return $nextBuyer["id"];
    }

    private function getNextJumpId(): int {
        // get next jump
        $jumps = new Jumps();
        return $jumps->selectNextJump();

        return $nextJump["id"];
    }

    public function insertNextBuyerJump() {
        // insert next buyer_jump data
        $nextBuyerId = $this->getNextBuyerId($this->getLastBuyerId());
        $nextJumpId = $this->getNextJumpId();
        $this->buyerJump->insert($nextBuyerId, $nextJumpId, false);

        var_dump('have inserted next buyer_jump data');
    }
}