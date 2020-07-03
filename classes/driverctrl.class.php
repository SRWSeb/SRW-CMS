<?php

class DriverCtrl {

  public static function getDriverNamebyID($driverID) {
    $driver = new Driver();
    $result = $driver->getDriver($driverID);
    return $result[0]['display_name'];
  }

  public function getDriverList() {
    $driver = new Driver();
    return $driver->getAllDrivers();
  }

  public function getDriverSeasonInfos($driverID, $seasonID) {
    $driver = new Driver();
    return $driver->getDriverSeasonInfos($driverID, $seasonID);
  }

  public function updateDriver($driverInfo, $seasonID) {
    $driver = new Driver();
    $season = new Season();
    $driverID = $driver->getDriverbyName($driverInfo['iracing_name']);
    $driverSeasonInfos = $driver->getDriverSeasonInfos($driverID, $seasonID);
    if (!isset($driverInfo['is_active'])) {
      $driverInfo['is_active'] = false;
    }

    if($driverInfo['display_name'] != $driver->getDisplayName()) {
      $driver->updateDisplayName($driverInfo['display_name']);
    }

    if($driverInfo['car_id'] != $driverSeasonInfos['selected_car_id']) {
      $season->updateDriverCar($driverID, $seasonID, $driverInfo['car_id']);
    }

    if ($driverInfo['class_id'] != $driverSeasonInfos['driver_class']) {
      $season->updateDriverClass($driverID, $seasonID, $driverInfo['class_id']);
    }

    if ($driverInfo['is_active'] != $driverSeasonInfos['active']) {
      $season->updateDriverStatus($driverID, $seasonID, $driverInfo['is_active']);
    }
  }

}
