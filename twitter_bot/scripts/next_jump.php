<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use TwitterBot\models\Jumps;
use TwitterBot\scripts\scraping\JumpScraping;

// get next jump info
$scraper = new JumpScraping();
$releaseDay = $scraper->scrapeNextJumpReleaseDay();
$price = $scraper->scrapeNextJumpPrice();
$combinedIssue = true; // TODO 取得の仕方が分かったら修正

// insert a next sold jump
$jumps = new Jumps();
$jumps->insert($releaseDay, $price, $combinedIssue);