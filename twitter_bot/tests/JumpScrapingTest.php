<?php

namespace TwitterBot\tests;

use PHPUnit\Framework\TestCase;
use TwitterBot\scripts\scraping\JumpScraping;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use \Exception;

class JumpScrapingTest extends TestCase {

    public function testScrapeNextJumpReleaseDay_normal() {
        // set stub
        $crawlerStub = $this->createMock(Crawler::class);
        $crawlerStub->method('text')->willReturn('1月3日');
        $crawlerStub->method('filter')->willReturn($crawlerStub);

        $clientStub = $this->createMock(Client::class);
        $clientStub->method('request')->willReturn($crawlerStub);

        // execute
        $scraper = new JumpScraping();
        $scraper->setClient($clientStub);
        $releaseDay = $scraper->scrapeNextJumpReleaseDay();
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
        $crawlerStub = $this->createMock(Crawler::class);
        $crawlerStub->method('text')->will($this->throwException(new Exception));
        $crawlerStub->method('filter')->willReturn($crawlerStub);

        $clientStub = $this->createMock(Client::class);
        $clientStub->method('request')->willReturn($crawlerStub);

        // execute
        $scraper = new JumpScraping();
        $scraper->setClient($clientStub);
        $scraper->scrapeNextJumpReleaseDay();
    }
}