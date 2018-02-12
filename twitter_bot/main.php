<?php
require dirname(__FILE__) . "/vendor/autoload.php";

use TwitterBot\service\TweetJumpBuyer;
use TwitterBot\service\NextJump;
use TwitterBot\service\NextJumpBuyer;

// tweet
$tweetJumpBuyer = new TweetJumpBuyer();
$buyerJumpInfo = $tweetJumpBuyer->tweetNextJumpBuyer();

// update buyer_jump(bought flag = 1)
if (!empty($buyerJumpInfo)) {

}

// insert next jump info
$nextJump = new NextJump();
$nextJump->insertNextJump();

// insert next buyer_jump info
$nextJumpBuyer = new NextJumpBuyer();
$nextJumpBuyer->insertNextBuyerJump();
