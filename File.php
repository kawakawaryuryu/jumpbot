<?php

class File {

    private $fp;
    private $filename;

    public function __construct() {
        $this->filename = dirname(__FILE__) . '/buyer.txt';

        if (!file_exists($this->filename)) {
            // ファイルが存在しない場合ははるぴーを入れる
            $this->updateLastBuyer('はるぴー');
        }
    }

    public function getLastBuyer() {
        $buyer = file_get_contents($this->filename);
        return $buyer;
    }

    public function updateLastBuyer($buyer) {
        file_put_contents($this->filename, $buyer);
    }
}
