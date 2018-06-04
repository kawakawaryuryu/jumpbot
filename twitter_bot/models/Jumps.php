<?php

namespace TwitterBot\models;

use PDO;

class Jumps extends DBConnection {

    const TABLE = 'jumps';

    public function insert(string $releaseDay, int $price, bool $combinedIssue) {
        $sql = 'insert into '. Jumps::TABLE .'(release_day, price, combined_issue) values(:release_day, :price, :combined_issue)';

        $sth = $this->db->prepare($sql);
        $sth->bindParam(':release_day', $releaseDay);
        $sth->bindParam(':price', $price);
        $combinedIssueParam = (int)$combinedIssue;
        $sth->bindParam(':combined_issue', $combinedIssueParam);

        $sth->execute();
    }

    public function selectNextJump(String $day = null): array {
        if(is_null($day)) {
            $day = date('Y-m-d');
        }
        $sql = 'select * from ' . Jumps::TABLE
            . ' where release_day > ?'
            . ' order by release_day limit 1';

        $sth = $this->db->prepare($sql);
        $sth->execute([$day]);

        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

        return empty($results) ? array() : $results[0];
    }
}
