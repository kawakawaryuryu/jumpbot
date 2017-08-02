<?php

class File {

    private $fp;

    public function __construct() {
        $filename = './buyer.txt';

        if (!file_exists($filename)) {
            // ファイルが存在しない場合ははるぴーを入れる
            $this->fp = fopen($filename, 'w+');
            $this->updateLastBuyer('はるぴー');
        } else {
            $this->fp = fopen($filename, 'r+');
        }

    }

    public function getLastBuyer() {
        $buyer = fgets($this->fp);
        return $buyer;
    }

    public function updateLastBuyer($buyer) {
        fwrite($this->fp, $buyer);
    }

    public function close() {
        fclose($this->fp);
    }

}
