<?php

namespace TwitterBot\tests;

use PHPUnit\Framework\TestCase;
use TwitterBot\scripts\scraping\JumpScraping;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class JumpScrapingTest extends TestCase {

    private $scraper;
    private $crawlerStub;
    private $clientStub;

    public function setUp() {
        $this->scraper = new JumpScraping();
        $this->crawlerStub = $this->createMock(Crawler::class);
        $this->clientStub = $this->createMock(Client::class);
    }

    public function testScrapeNextJumpReleaseDay_normal() {
        // set stub
        $this->crawlerStub->method('text')->willReturn('1月3日');
        $this->crawlerStub->method('filter')->willReturn($this->crawlerStub);
        $this->clientStub->method('request')->willReturn($this->crawlerStub);

        // execute
        $this->scraper->setClient($this->clientStub);
        $releaseDay = $this->scraper->scrapeNextJumpReleaseDay();
        echo $releaseDay;

        // check
        $pattern = '/[1-9][0-9]{3}-(1[0-2]|0[1-9])-(0[1-9]|[12][0-9]|3[01])/';
        $this->assertEquals(1, preg_match($pattern, $releaseDay));
    }

    /**
     * @expectedException Exception
     */
    public function testScrapeNextJumpReleaseDay_exception() {
        // set stub
        $this->crawlerStub->method('text')->willReturn('140月14日');
        $this->crawlerStub->method('filter')->willReturn($this->crawlerStub);
        $this->clientStub->method('request')->willReturn($this->crawlerStub);

        // execute
        $this->scraper->setClient($this->clientStub);
        $this->scraper->scrapeNextJumpReleaseDay();
    }
}