<?php

namespace TwitterBot\models;

use PDO;

class BuyerJump extends DBConnection {

    const TABLE = 'buyer_jump';

    public function selectNextBuyersJumps($nextReleaseDay): array {
        $sql = 'select * from '. Buyers::TABLE
             . ' inner join '. BuyerJump::TABLE .' on '. Buyers::TABLE .'.id = '. BuyerJump::TABLE .'.buyer_id'
             . ' inner join '. Jumps::TABLE .' on '. BuyerJump::TABLE .'.jump_id = '. Jumps::TABLE .'.id'
             . ' where '. Jumps::TABLE .'.release_day = ?';

        $sth = $this->db->prepare($sql);
        $sth->execute([$nextReleaseDay]);

        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

        return empty($results) ? array() : $results[0];
    }

    public function selectLastBuyersJumps(string $day = null): array {
        if(is_null($day)) {
            // today
            $day = date('Y-m-d');
        }
        $sql = 'select * from '. Buyers::TABLE
            . ' inner join '. BuyerJump::TABLE .' on '. Buyers::TABLE .'.id = '. BuyerJump::TABLE .'.buyer_id'
            . ' inner join '. Jumps::TABLE .' on '. BuyerJump::TABLE .'.jump_id = '. Jumps::TABLE .'.id'
            . ' where release_day < ?'
            . ' order by release_day desc limit 1';

        $sth = $this->db->prepare($sql);
        $sth->execute([$day]);

        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

        return empty($results) ? array() : $results[0];
    }

    public function insert(int $buyerId, int $jumpId, bool $bought) {
        $sql = 'insert into '. BuyerJump::TABLE .'(buyer_id, jump_id, bought) values(:buyer_id, :jump_id, :bought)';

        $sth = $this->db->prepare($sql);
        $sth->bindParam(':buyer_id', $buyerId);
        $sth->bindParam(':jump_id', $jumpId);
        $boughtParam = (int)$bought;
        $sth->bindParam(':bought', $boughtParam);

        $sth->execute();
    }
}
