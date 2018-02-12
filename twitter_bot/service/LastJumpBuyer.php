<?php

namespace TwitterBot\service;

use TwitterBot\models\BuyerJump;
use TwitterBot\models\BuyerJumpEntity;

class LastJumpBuyer {

    private $buyerJump;

    public function __construct() {
        $this->buyerJump = new BuyerJump();
    }

    public function setBuyerJump(BuyerJump $buyerJump) {
        $this->buyerJump = $buyerJump;
    }

    public function boughtJump(array $buyerJumpInfo) {
        if (!empty($buyerJumpInfo)) {
            $buyerJumpEntity = new BuyerJumpEntity(
                $buyerJumpInfo["id"],
                $buyerJumpInfo["buyer_id"],
                $buyerJumpInfo["jump_id"],
                true
            );
            $this->buyerJump->update($buyerJumpEntity);
        }
    }
}