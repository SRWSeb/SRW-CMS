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

  public function getDriver($driverID) {
    $sql = "SELECT * FROM drivers WHERE id = ?";
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$driverID]);

    $result = $stmt->fetchAll();
    return $result;
  }

}
