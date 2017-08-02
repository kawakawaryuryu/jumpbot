<?php

require './Twitter.php';
require './File.php';

// get last jump buyer
$file = new File();
$buyer = $file->getLastBuyer();

// tweet jump buyer on this week
$tw = new Twitter($buyer);
$tw->tweet();
