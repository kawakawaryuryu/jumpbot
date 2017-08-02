<?php

class File {

    private $fp;

    public function __construct() {
        $this->fp = fopen('./buyer.txt', 'r+');
    }

    public function getLastBuyer() {
        $buyer = fgets($this->fp);
        return $buyer;
    }

    public function updateLastBuyer($buyer) {
        fwrite($this->fp, $buyer);
    }

    public function __destruct() {
        fclose($this->fp);
    }
}
