<?php

namespace TwitterBot\models;

use PDO;

class BuyerJump extends DBConnection {

    private static $table = 'buyer_jump';

    public function selectNextBuyersJumps($nextReleaseDay) {
        $sql = 'select * from buyers'
             . ' inner join buyer_jump on buyers.id = buyer_jump.buyer_id'
             . ' inner join jumps on buyer_jump.jump_id = jumps.id'
             . ' where jumps.release_day = ?';

        $sth = $this->db->prepare($sql);
        $sth->execute([$nextReleaseDay]);

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function insert(int $buyerId, int $jumpId, bool $bought) {
        $sql = 'insert into '. self::$table .'(buyer_id, jump_id, bought) values(:buyer_id, :jump_id, :bought)';

        $sth = $this->db->prepare($sql);
        $sth->bindParam(':buyer_id', $buyerId);
        $sth->bindParam(':jump_id', $jumpId);
        $boughtParam = (int)$bought;
        $sth->bindParam(':bought', $boughtParam);

        $sth->execute();
    }
}
