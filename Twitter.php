<?php

require "./vendor/autoload.php";
require "./config.php";

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter {

    private $buyer;
    private $connection;

    public function __construct() {

        $this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

        $this->buyer = 'りゅう';
    }

    public function tweet() {
    
        $content = $this->connection->post('statuses/update', ['status' => $this->tweetMessage()]);

    }

    private function tweetMessage() {
        return "今週はジャンプは $this->buyer です";
    }

}

