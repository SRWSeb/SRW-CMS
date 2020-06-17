<?php

class Season extends Dbc {
  private $seasonInfo = array();
  private $seasonDriverInfo = array();

    public function seasonbyID($seasonID) {
      $sql = "SELECT * FROM seasons WHERE id = ?";
      $this->connect();
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$seasonID]);
      $resultSeasonInfo = $stmt->fetchAll();

      $sql = "SELECT season_driver_info.*, drivers.display_name, cars.car_name FROM season_driver_info
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
