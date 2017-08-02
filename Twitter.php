<?php

require "./vendor/autoload.php";
require "./config.php";

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter {

    private $connection;
    private $buyer;

    public function __construct($buyer) {

        $this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

        $this->buyer = $buyer;
    }

    public function tweet() {
    
        $content = $this->connection->post('statuses/update', ['status' => $this->tweetMessage()]);

    }

    private function tweetMessage() {
        return "今週はジャンプは $this->buyer です";
    }

}

