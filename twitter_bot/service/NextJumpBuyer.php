<?php

namespace TwitterBot\service;

use TwitterBot\models\BuyerJump;
use TwitterBot\models\Buyers;
use TwitterBot\models\Jumps;
use Exception;

class NextJumpBuyer {

    private $buyerJump;
    private $buyers;
    private $jumps;

    public function __construct() {
        $this->buyerJump = new BuyerJump();
        $this->buyers = new Buyers();
        $this->jumps = new Jumps();
    }

    public function setBuyerJump(BuyerJump $buyerJump) {
        $this->buyerJump = $buyerJump;
    }

    public function setBuyers(Buyers $buyers) {
        $this->buyers = $buyers;
    }

    public function setJumps(Jumps $jumps) {
        $this->jumps = $jumps;
    }

    private function getLastBuyerId(): int {
        // get last buyer and jump info
        $lastBuyersJumps = $this->buyerJump->selectLastBuyersJumps();
        // TODO 何を返すのが適切か
        return empty($lastBuyersJumps) ? null : $lastBuyersJumps["buyer_id"];
    }

    private function getNextBuyerId(int $lastBuyerId): int {
        // get next buyer
        $nextBuyer = $this->buyers->selectNextActiveBuyer($lastBuyerId);
        return $nextBuyer["id"];
    }

    private function getNextJumpId(): int {
        // get next jump
        $nextJump =  $this->jumps->selectNextJump();

        if (empty($nextJump)) {
            throw new Exception('no jumps');
        }

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