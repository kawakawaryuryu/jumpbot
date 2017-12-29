<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use TwitterBot\models\Jumps;

// insert a next sold jump
$jumps = new Jumps();
$releaseDay = date('Y-m-d', mktime(0, 0, 0, 12, 25, 2017));
$price = 270;
$combinedIssue = true;
$jumps->insert($releaseDay, $price, $combinedIssue);