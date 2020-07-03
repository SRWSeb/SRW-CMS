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

  public function getDriverSeasonInfos($driverID, $seasonID) {
    $sql = "SELECT season_driver_info.*, drivers.*, cars.car_name FROM season_driver_info
            JOIN drivers ON season_driver_info.driver_id = drivers.id
            JOIN cars ON season_driver_info.selected_car_id = cars.id
            WHERE driver_id = ? AND season_id = ?";

    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$driverID, $seasonID]);

    $result = $stmt->fetchAll();
    return $result;
  }

}
