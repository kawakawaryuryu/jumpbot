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
    
        $statues = $this->connection->post('statuses/update', ['status' => $this->tweetMessage()]);
        var_dump($statues);
    }

    public function tweetMessage() {
        $date = date('Y/m/d D H:i:s');
        return "$date\n 今週のジャンプは $this->buyer です";
    }

}

