<?php

namespace TwitterBot\models;

use PDO;

class BuyerJump extends DBConnection {

    const TABLE = 'buyer_jump';

    public function selectNextBuyersJumps($nextReleaseDay) {
        $sql = 'select * from '. Buyers::TABLE
             . ' inner join '. BuyerJump::TABLE .' on '. Buyers::TABLE .'.id = '. BuyerJump::TABLE .'.buyer_id'
             . ' inner join '. Jumps::TABLE .' on '. BuyerJump::TABLE .'.jump_id = '. Jumps::TABLE .'.id'
             . ' where '. Jumps::TABLE .'.release_day = ?';

        $sth = $this->db->prepare($sql);
        $sth->execute([$nextReleaseDay]);

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
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
