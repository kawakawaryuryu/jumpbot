<?php
require dirname(__FILE__) . "/../vendor/autoload.php";

use TwitterBot\service\TweetJumpBuyer;

$tweetJumpBuyer = new TweetJumpBuyer();
$tweetJumpBuyer->tweetNextJumpBuyer();
