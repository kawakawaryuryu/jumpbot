<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use TwitterBot\service\NextJumpBuyer;

// insert next buyer_jump data
$nextJumpBuyer = new NextJumpBuyer();
$nextJumpBuyer->insertNextBuyerJump();