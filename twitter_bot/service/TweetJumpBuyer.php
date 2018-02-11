<?php

namespace TwitterBot\service;

use TwitterBot\models\BuyerJump;
use TwitterBot\twitter\Twitter;

class TweetJumpBuyer {

    private $buyerJump;
    private $tw;

    public function __construct() {
        $this->buyerJump = new BuyerJump();
        $this->tw = new Twitter();
    }

    public function setBuyerJump(BuyerJump $buyerJump) {
        $this->buyerJump = $buyerJump;
    }

    public function setTwitter(Twitter $tw) {
        $this->tw = $tw;
    }

    public function tweetNextJumpBuyer() {
        date_default_timezone_set('Asia/Tokyo');

        $result = $this->buyerJump->selectNextBuyersJumps();

        if (empty($result)) {
            // no sold jump today
            echo("no sold jump today".PHP_EOL);

        } else {
            $buyer = $result['name'];

            // tweet jump buyer on this week
            $res = $this->tw->tweet($buyer);
            echo($res);
        }
    }
}