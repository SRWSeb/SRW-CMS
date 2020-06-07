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
  header("Location: ../index.php?action=logout");
  exit();
}

if($_GET['action'] == "login") {
  if($_POST['username'] == "" || $_POST['passwd'] == "") {
    header("Location: ../index.php?action=credentials");
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
