<?php
require dirname(__FILE__) . "/vendor/autoload.php";

use TwitterBot\twitter\Twitter;
use TwitterBot\models\File;

date_default_timezone_set('Asia/Tokyo');

$file = new File();

// get all buyers
$buyers = $file->buyers();
//$file->updateBuyer(0, 1);

// get this week jump buyer
$buyerInfo = $file->buyerInfo();
$buyerId = $buyerInfo['nextBuyer'];
$buyer = $buyers[$buyerId]['buyer'];
//var_dump($nextBuyer);

// tweet jump buyer on this week
$tw = new Twitter();
var_dump($tw->tweet($buyer));

// update jump buyer
$file->updateBuyer($buyerId, nextBuyerId($buyerId, $buyers));

function nextBuyerId($buyerId, $allBuyers) {
    return ($buyerId + 1) % count($allBuyers);
}
