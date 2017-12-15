<?php

namespace TwitterBot\models;

class Jumps extends DBConnection {

    private static $table = 'jumps';

    public function insert(string $releaseDay, int $price, bool $combinedIssue) {
        $sql = 'insert into '. self::$table .'(release_day, price, combined_issue) values(:release_day, :price, :combined_issue)';

        $sth = $this->db->prepare($sql);
        $sth->bindParam(':release_day', $releaseDay);
        $sth->bindParam(':price', $price);
        $combinedIssueParam = (int)$combinedIssue;
        $sth->bindParam(':combined_issue', $combinedIssueParam);

        $sth->execute();
    }
}
