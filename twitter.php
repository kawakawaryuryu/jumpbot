<?php

require "./vendor/autoload.php";
require "./config.php";

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter {

    public function tweet() {
    
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $content = $connection->post("statuses/update", ["status" => "今週ははるぴーです"]);

    }

}

