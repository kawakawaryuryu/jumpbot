<?php
date_default_timezone_set('Asia/Tokyo');

require dirname(__FILE__) . '/Twitter.php';
require dirname(__FILE__) . '/File.php';

$jumpBuyers = [
    0 => 'りゅう',
    1 => 'はるぴー'
];
// get last jump buyer
$file = new File();
$buyer = $file->getLastBuyer();
var_dump($buyer);

// tweet jump buyer on this week
$tw = new Twitter($buyer);
$tw->tweet();
var_dump($tw->tweetMessage());

// update jump buyer
var_dump(nextJumpBuyer($buyer, $jumpBuyers));
$file = new File();
$file->updateLastBuyer(nextJumpBuyer($buyer, $jumpBuyers));

function nextJumpBuyer($buyer, $allBuyers) {
    $key = array_search($buyer, $allBuyers);
    return $allBuyers[($key + 1) % count($allBuyers)];
}

