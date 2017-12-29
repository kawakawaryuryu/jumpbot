<?php
namespace TwitterBot\twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use TwitterBot\config\Config;

class Twitter {

    private $connection;
    private $buyer;

    public function __construct($buyer) {

        $this->connection = new TwitterOAuth(Config::CONSUMER_KEY, Config::CONSUMER_SECRET, Config::ACCESS_TOKEN, Config::ACCESS_TOKEN_SECRET);

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

