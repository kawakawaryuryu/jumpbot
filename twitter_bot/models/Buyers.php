<?php

namespace TwitterBot\models;

use PDO;
use Exception;

class Buyers extends DBConnection {

    const TABLE = 'buyers';

    public function selectActiveBuyers(): array {
        $sql = 'select * from ' . Buyers::TABLE
             . ' where deleted_at is null';

        $sth = $this->db->query($sql);

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * get next active buyer
     * @param int $buyerId last buyer
     * @return array
     * @throws Exception
     */
    public function selectNextActiveBuyer(int $buyerId): array {
        $activeBuyers = $this->selectActiveBuyers();

        if (count($activeBuyers) == 0) {
            throw new Exception("No Active Buyers");
        }

        for ($i = 0; $i < count($activeBuyers); $i++) {
            if ($activeBuyers[$i]["id"] == $buyerId) {
                return $activeBuyers[($i + 1) % count($activeBuyers)];
            }
        }
        throw new Exception("buyer_id is invalid");
    }
}