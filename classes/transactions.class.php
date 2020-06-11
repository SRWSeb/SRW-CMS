<?php

class Transactions extends Dbc {
  
  public function getPtsTransactionsForSeason ($seasonID, $driverID) {
    $sql = "SELECT champ_pts_transactions.*, rounds.* FROM champ_pts_transactions
    JOIN rounds ON champ_pts_transactions.rounds_id = rounds.id
    WHERE season_id = ? AND driver_id = ? ORDER BY round_num ASC";

    $this->connect();

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$seasonID, $driverID]);

    $results = $stmt->fetchAll();
    return $results;
  }


}
