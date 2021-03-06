<?php

namespace TwitterBot\scraping;

use Goutte\Client;
use \DateTime;
use \Exception;

class JumpScraping {

    private $client;

    private $text;

    public function __construct() {
        $this->client = new Client();
    }

    public function setClient(Client $client) {
        $this->client = $client;
    }

    public function scrape(): void {
        // TODO move url parameter to config
        $crawler = $this->client->request('GET', 'http://www.shonenjump.com/j/weeklyshonenjump/');
        $this->text = $crawler->filter('a#nextWJ > p')->text();
    }

    public function scrapeNextJumpReleaseDay(): String {
        if (is_null($this->text)) {
            $this->scrape();
        }
        $releaseDay = $this->extractReleaseDay($this->text);

        return $releaseDay->format('Y-m-d');
    }

    public function scrapeNextJumpPrice(): int {
        if (is_null($this->text)) {
            $this->scrape();
        }

        return $this->extractPrice($this->text);
    }

    private function extractReleaseDay($text): DateTime {
        $pattern = '/([1-9]|1[0-2])月([1-9]|[12][0-9]|3[01])日/';
        $result = preg_match($pattern, $text, $matches);
        if (!$result) {
            throw new Exception("failed to scrape next jump release day");
        }

        $month = $matches[1];
        $day = $matches[2];

        $today = new DateTime();
        $releaseDay = new DateTime("$month/$day");

        // in case that release day is next year
        if ($today->diff($releaseDay)->invert == 1) {
            $year = $today->format('Y') + 1;
        } else {
            $year = $today->format('Y');
        }

        return $releaseDay->setDate($year, $month, $day);
    }

    private function extractPrice($text): int {
        $pattern = '/.*定価:([0-9]{2,})円.*/';
        $result = preg_match($pattern, $text, $matches);
        if (!$result) {
            throw new Exception("failed to scrape next jump price");
        }

        $price = $matches[1];

        return $price;
    }
}
