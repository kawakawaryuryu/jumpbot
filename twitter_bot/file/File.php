<?php

namespace TwitterBot\file;

class File {

    private $buyersFile;
    private $buyerFile;

    private $buyers;
    private $buyerInfo;

    public function __construct() {
        $filePath = dirname(__FILE__) . '/../data';
        $this->buyersFile = $filePath . '/buyers.json';
        $this->buyerFile = $filePath . '/buyer.json';

        if (!(file_exists($this->buyersFile) && file_exists($this->buyerFile))) {
            // ファイルが存在しない場合はエラーを返す
            throw new Exception("$this->buyerFiles or $this->buyerFile not found");
        }
    }

    public function buyers() {
        $this->buyers = json_decode(file_get_contents($this->buyersFile), TRUE);
        return $this->buyers;
    }

    public function buyerInfo() {
        $this->buyerInfo = json_decode(file_get_contents($this->buyerFile), TRUE);
        return $this->buyerInfo;
    }

    public function updateBuyer(int $lastBuyer, int $nextBuyer) {
        $buyerInfo['lastBuyer'] = $lastBuyer;
        $buyerInfo['nextBuyer'] = $nextBuyer;
        file_put_contents($this->buyerFile, json_encode($buyerInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

}
