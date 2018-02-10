<?php

namespace TwitterBot\service;

use TwitterBot\models\Jumps;
use TwitterBot\scraping\JumpScraping;

class NextJump {

    private function getNextJump(): Jump {
        // get next jump info
        $scraper = new JumpScraping();
        $releaseDay = $scraper->scrapeNextJumpReleaseDay();
        $price = $scraper->scrapeNextJumpPrice();
        $combinedIssue = false; // TODO 取得の仕方が分かったら修正

        return new Jump(
            $releaseDay, $price, $combinedIssue
        );
    }

    public function insertNextJump() {
        $nextJump = $this->getNextJump();
        // insert a next sold jump
        $jumps = new Jumps();
        $jumps->insert($nextJump->releaseDay, $nextJump->price, $nextJump->combinedIssue);
        var_dump('inserted next jump info');
    }
}

class Jump {
    public $releaseDay;
    public $price;
    public $combinedIssue;

    public function __construct($releaseDay, $price, $combinedIssue) {
        $this->releaseDay = $releaseDay;
        $this->price = $price;
        $this->combinedIssue = $combinedIssue;
    }
}

