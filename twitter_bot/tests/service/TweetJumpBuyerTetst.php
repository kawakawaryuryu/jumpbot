<?php

namespace TwitterBot\tests\service;

use PHPUnit\Framework\TestCase;
use TwitterBot\models\BuyerJump;
use TwitterBot\service\TweetJumpBuyer;
use TwitterBot\twitter\Twitter;

class TweetJumpBuyerTest extends TestCase {

    private $tweetJumpBuyer;

    private $buyerJumpMock;
    private $twitterMock;

    public function setUp() {
        $this->tweetJumpBuyer = new TweetJumpBuyer();
        $this->buyerJumpMock = $this->createMock(BuyerJump::class);
        $this->twitterMock = $this->createMock(Twitter::class);
    }

    public function testTweetNextJumpBuyer_normal() {
        // set mock
        $this->buyerJumpMock->method('selectNextBuyersJumps')->willReturn([
            "name" => "user",
            "buyer_id" => 1,
            "jump_id" => 1,
            "bought" => 0
        ]);
        $this->tweetJumpBuyer->setBuyerJump($this->buyerJumpMock);

        $this->twitterMock->expects($this->once())->method('tweet')
            ->willReturn('done tweeted');
        $this->tweetJumpBuyer->setTwitter($this->twitterMock);

        // execute
        $this->tweetJumpBuyer->tweetNextJumpBuyer();
    }

    public function testTweetNextJumpBuyer_nextBuyersJumpsEmpty() {
        // set mock
        $this->buyerJumpMock->method('selectNextBuyersJumps')->willReturn([]);
        $this->tweetJumpBuyer->setBuyerJump($this->buyerJumpMock);

        $this->twitterMock->expects($this->never())->method('tweet');
        $this->tweetJumpBuyer->setTwitter($this->twitterMock);

        // expected result
        $this->expectOutputRegex('/.*no sold jump today.*/');

        // execute
        $this->tweetJumpBuyer->tweetNextJumpBuyer();
    }
}