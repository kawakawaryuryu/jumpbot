<?php

class File {

    private $buyersFile;
    private $buyerFile;

    public function __construct() {
        $filePath = dirname(__FILE__) . '/data';
        $this->buyersFile = $filePath . '/buyers.json';
        $this->buyerFile = $filePath . '/buyer.json';

        if (!(file_exists($this->buyersFile) && file_exists($this->buyerFile))) {
            // ファイルが存在しない場合はエラーを返す
            throw new Exception("$this->buyerFiles or $this->buyerFile not found");
        }
    }

    public function buyers() {
        $buyers = json_decode(file_get_contents($this->buyersFile), TRUE);
        return $buyers;
    }

    public function buyerInfo() {
        $buyer = json_decode(file_get_contents($this->buyerFile), TRUE);
        return $buyer;
    }

}
