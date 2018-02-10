<?php

namespace TwitterBot\service;

use TwitterBot\models\BuyerJump;
use TwitterBot\models\Buyers;
use TwitterBot\models\Jumps;
use Exception;

class NextJumpBuyer {

    private $buyerJump;

    public function __construct() {
        $this->buyerJump = new BuyerJump();
    }

    private function getLastBuyerId(): int {
        // get last buyer and jump info
        $lastBuyersJumps = $this->buyerJump->selectLastBuyersJumps();
        if (empty($lastBuyersJumps)) {
            // get first active buyer
            $buyers = new Buyers();
            $activeBuyers = $buyers->selectActiveBuyers();

            if (empty($activeBuyers)) {
                throw new Exception('no active buyers');
            }
            return $activeBuyers[0]["id"];
        }
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
        $nextJump =  $jumps->selectNextJump();

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