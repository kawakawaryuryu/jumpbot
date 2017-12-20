<?php

namespace TwitterBot\models;

use PDO;

class Buyers extends DBConnection {

    const TABLE = 'buyers';

    public function selectActiveBuyers(): array {
        $sql = 'select * from ' . Buyers::TABLE
             . ' where deleted_at is null';

        $result = $this->db->query($sql);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}