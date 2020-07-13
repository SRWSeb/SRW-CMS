<?php

class Protest extends Dbc {

  public function createProtest($datalist) {
    $sql = 'INSERT INTO protest (season_id, round_id, issued_by, protested_driver, lap, location, yt_direct, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$datalist['seasonID'], $datalist['roundID'], $datalist['issuedBy'], $datalist['protestedDriver'], $datalist['lap'], $datalist['location'], $datalist['youtube'], $datalist['description']]);

    return $this->conn->lastInsertId();
  }

  public function getProtest($protestID) {
    $sql = 'SELECT * FROM protest WHERE id = ?';

    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$protestID]);
    $result = $stmt->fetchAll();

    return $result;
  }

  public function getAllProtests() {
    $sql = 'SELECT protest.*, drivers.display_name, rounds.round_num FROM protest
            JOIN drivers ON drivers.id = protest.protested_driver
            JOIN rounds ON rounds.id = protest.round_id';

    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([]);
    $result = $stmt->fetchAll();

    return $result;
  }

}
