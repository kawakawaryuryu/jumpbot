<?php
require dirname(__FILE__) . "/vendor/autoload.php";

use TwitterBot\twitter\Twitter;
use TwitterBot\models\BuyerJump;

date_default_timezone_set('Asia/Tokyo');

$buyerJump = new BuyerJump();
//$today = date('Y-m-d');
$today = date('Y-m-d', mktime(0, 0, 0, 10, 23, 2017));
$results = $buyerJump->selectNextBuyersJumps($today);

if (empty($results)) {
    // no sold jump today
    var_dump("no sold jump today");

} else {
    foreach($results as $result) {
        $buyer = $result['name'];

        // tweet jump buyer on this week
        $tw = new Twitter($buyer);
        $tw->tweet();
        var_dump($tw->tweetMessage());
    }
}
