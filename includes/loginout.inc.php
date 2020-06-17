<?php
session_start();
require 'autoloader.inc.php';
$userCtrl = new UserCtrl();

if(!isset($_GET['action'])) {
  header("Location: ../index.php");
  exit();
}

if($_GET['action'] == "logout") {
  unset($_SESSION['loggedin']);
  unset($_SESSION['name']);
  unset($_SESSION['userlevel']);
  header("Location: ../index.php?action=logout");
  exit();
}

if($_GET['action'] == "login") {
  if(empty($_POST['username']) || empty($_POST['passwd'])) {
    header("Location: ../index.php?action=loginFailed");
    exit();
  }
  if($userCtrl->loginUser($_POST['username'], $_POST['passwd'])) {
    header("Location: ../index.php?action=loginSuccess");
    exit();
  } else {
    header("Location: ../index.php?action=loginFailed");
    exit();
  }
}
header("Location: ../index.php");
exit();
