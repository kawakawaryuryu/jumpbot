<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use TwitterBot\models\BuyerJump;
use TwitterBot\models\Buyers;
use TwitterBot\models\Jumps;

$buyerJump = new BuyerJump();
// get last buyer and jump info
$lastBuyersJumps = $buyerJump->selectLastBuyersJumps();
$lastBuyerId = $lastBuyersJumps["buyer_id"];

// get next buyer
$buyers = new Buyers();
$nextBuyer = $buyers->selectNextActiveBuyer($lastBuyerId);

// get next jump
$jumps = new Jumps();
$nextJump = $jumps->selectNextJump();

// insert next buyer_jump data
$buyerJump->insert($nextBuyer["id"], $nextJump["id"], false);

var_dump('have inserted next buyer_jump data');
