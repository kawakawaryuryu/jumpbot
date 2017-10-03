<?php

namespace TwitterBot\models;

use PDO;

class BuyerJump extends DBConnection {

    public function selectNextBuyersJumps($nextReleaseDay) {
        $sql = 'select * from buyers'
             . ' inner join buyer_jump on buyers.id = buyer_jump.buyer_id'
             . ' inner join jumps on buyer_jump.jump_id = jumps.id';

        $sth = $this->db->prepare($sql);
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
