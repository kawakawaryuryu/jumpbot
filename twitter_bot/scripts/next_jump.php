<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use TwitterBot\service\NextJump;

// insert a next sold jump
$nextJump = new NextJump();
$nextJump->insertNextJump();
