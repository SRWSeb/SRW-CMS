<?php

class Season extends Dbc {

    public function getSeasonInfo($seasonID) {
      $sql = "SELECT * FROM seasons WHERE id = ?";

      $this->connect();

      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$seasonID]);

      $result = $stmt->fetchAll();
      return $result;
    }

    public function getSeasonDriverInfo($seasonID) {
      $sql = "SELECT season_driver_info.*, drivers.display_name, cars.car_name FROM season_driver_info
      JOIN drivers ON season_driver_info.driver_id = drivers.id
      JOIN cars ON season_driver_info.selected_car_id = cars.id
      WHERE season_id = ?";

      $this->connect();

      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$seasonID]);

      $results = $stmt->fetchAll();
      return $results;
    }




}
