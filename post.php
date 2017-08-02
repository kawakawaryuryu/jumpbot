<?php

require "./vendor/autoload.php";
require "./config.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
$content = $connection->post("statuses/update", ["status" => "今週ははるぴーです"]);

var_dump($content);
