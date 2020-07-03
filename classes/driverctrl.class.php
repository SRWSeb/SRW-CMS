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

}
