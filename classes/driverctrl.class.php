<?php

class DriverCtrl {

  public function getDriverList() {
    $driver = new Driver();
    return $driver->getAllDrivers();
  }

}
