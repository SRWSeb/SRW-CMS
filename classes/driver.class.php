<?php

class Driver extends Dbc {

  public function getAllDrivers() {
    $sql = "SELECT * FROM drivers";
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll();
    return $results;
  }

}
