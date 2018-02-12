<?php
require dirname(__FILE__) . "/vendor/autoload.php";

use TwitterBot\service\TweetJumpBuyer;
use TwitterBot\service\NextJump;
use TwitterBot\service\NextJumpBuyer;
use \TwitterBot\service\LastJumpBuyer;

// tweet
$tweetJumpBuyer = new TweetJumpBuyer();
$buyerJumpInfo = $tweetJumpBuyer->tweetNextJumpBuyer();

// update buyer_jump(bought flag = 1)
$lastJumpBuyer = new LastJumpBuyer();
$lastJumpBuyer->boughtJump($buyerJumpInfo);

// insert next jump info
$nextJump = new NextJump();
$nextJump->insertNextJump();

// insert next buyer_jump info
$nextJumpBuyer = new NextJumpBuyer();
$nextJumpBuyer->insertNextBuyerJump();
