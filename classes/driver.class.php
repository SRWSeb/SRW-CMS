<?php

class Driver extends Dbc {
  private $db_id = 0;
  private $iracing_id = 0;
  private $iracing_name = '';
  private $display_name = '';

  public function getDisplayName() {
    return $this->display_name;
  }

  public function updateDisplayName($newName) {
    $sql = "UPDATE drivers SET display_name = ? WHERE id = ?";
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$newName, $this->db_id]);
    $this->display_name = $newName;

    return true;
  }


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

  public function getDriverbyName($name) {
    $sql = "SELECT * FROM drivers WHERE iracing_name = ?";
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$name]);

    $result = $stmt->fetchAll();

    $this->db_id = $result[0]['id'];
    $this->iracing_id = $result[0]['iracing_id'];
    $this->iracing_name = $result[0]['iracing_name'];
    $this->display_name = $result[0]['display_name'];

    return $this->db_id;
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
