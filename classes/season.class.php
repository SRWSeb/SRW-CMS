<?php

class Season extends Dbc {
  private $seasonInfo = array();
  private $seasonDriverInfo = array();

    public function getCarsForSeason($seasonID) {
      $sql = "SELECT seasons.carclass_id, carclass_cars.*, cars.car_name FROM seasons
              JOIN carclass_cars ON seasons.carclass_id = carclass_cars.carclass_id
              JOIN cars ON carclass_cars.car_id = cars.id
              WHERE seasons.id = ?";

      $this->connect();
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$seasonID]);
      $result = $stmt->fetchAll();

      return $result;
    }

    public function getClasses() {
      $sql = "SELECT * FROM driverclasses";
      $this->connect();
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();

      return $result;
    }

    public function updateDriverClass($driverID, $seasonID, $newClassID) {
      $sql = "UPDATE season_driver_info SET driver_class = ? WHERE season_id = ? AND driver_id = ?";
      $this->connect();
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$newClassID, $seasonID, $driverID]);

      return true;
    }

    public function updateDriverCar($driverID, $seasonID, $newCarID) {
      $sql = "UPDATE season_driver_info SET selected_car_id = ? WHERE season_id = ? AND driver_id = ?";
      $this->connect();
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$newCarID, $seasonID, $driverID]);

      return true;
    }

    public function updateDriverStatus($driverID, $seasonID, $isActive) {
      $sql = "UPDATE season_driver_info SET active = ? WHERE season_id = ? AND driver_id = ?";
      $this->connect();
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$newCarID, $seasonID, $active]);

      return true;
    }

    public function seasonbyID($seasonID) {
      $sql = "SELECT * FROM seasons WHERE id = ?";
      $this->connect();
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$seasonID]);
      $resultSeasonInfo = $stmt->fetchAll();

      $sql = "SELECT season_driver_info.*, drivers.*, cars.car_name FROM season_driver_info
      JOIN drivers ON season_driver_info.driver_id = drivers.id
      JOIN cars ON season_driver_info.selected_car_id = cars.id
      WHERE season_id = ?";
      $this->connect();
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$seasonID]);
      $resultSeasonDriverInfo = $stmt->fetchAll();

      if (empty($resultSeasonInfo) || empty($resultSeasonDriverInfo)) {
        return false;
      }

      $this->seasonInfo = $resultSeasonInfo[0];
      $this->seasonDriverInfo = $resultSeasonDriverInfo;

      return true;
    }

    public function getSeasonDriverInfo() {
      return $this->seasonDriverInfo;
    }

    public function getSeasonInfo() {
      return $this->seasonInfo;
    }

}
