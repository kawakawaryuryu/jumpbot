<?php

require dirname(__FILE__) . "/vendor/autoload.php";
require dirname(__FILE__) . "/config.php";

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
        //var_dump($statues);
    }

    public function tweetMessage() {
        $date = date('Y/m/d D H:i');
        return "$date\n 今週のジャンプは $this->buyer です";
    }

}

