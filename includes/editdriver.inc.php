<?php

session_start();
require 'autoloader.inc.php';

if(!isset($_GET['season'])) {
  header("Location: ../index.php");
  exit();
}

if(!isset($_POST['iracing_name'])) {
  header("Location: ../index.php");
  exit();
}

$driverCtrl = new DriverCtrl();
$driverCtrl->updateDriver($_POST, $_GET['season']);

header("Location: ../driveradmin.php?season=".$_GET['season']);
