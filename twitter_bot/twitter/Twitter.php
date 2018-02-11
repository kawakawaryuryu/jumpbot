<?php
namespace TwitterBot\twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use TwitterBot\config\Config;

class Twitter {

    private $connection;

    public function __construct() {
        $this->connection = new TwitterOAuth(Config::CONSUMER_KEY, Config::CONSUMER_SECRET, Config::ACCESS_TOKEN, Config::ACCESS_TOKEN_SECRET);
    }

    public function tweet(String $buyer) {
        $statues = $this->connection->post('statuses/update', ['status' => $this->tweetMessage($buyer)]);
        return "message: $statues->text" .PHP_EOL;
    }

    private function tweetMessage(String $buyer) {
        $date = date('Y/m/d D H:i');
        return "$date\n 今週のジャンプは $buyer です";
    }

}

