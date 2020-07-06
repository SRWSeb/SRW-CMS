<?php

class Protest extends Dbc {

  public function createProtest($datalist) {
    $sql = 'INSERT INTO protest (season_id, round_id, issued_by, protested_driver, lap, location, yt_embed, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$datalist['seasonID'], $datalist['roundID'], $datalist['issuedBy'], $datalist['protestedDriver'], $datalist['lap'], $datalist['location'], $datalist['ytembed'], $datalist['description']]);

    return true;
  }


}
