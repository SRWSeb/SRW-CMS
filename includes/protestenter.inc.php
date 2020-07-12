<?php
require 'autoloader.inc.php';

if(!isset($_POST['issuedBy']) || !isset($_POST['protestedDriver']) || !isset($_POST['lap']) || !isset($_POST['location']) || !isset($_POST['description']) || !isset($_GET['season'])) {
  header("Location: ../index.php");
  exit();
}

$protestCtrl = new ProtestCtrl();
$protestCtrl->setNewProtest($_GET['season'], $_POST);
$protestCtrl->saveProtest();

header("Location: ../protestenter.php?protest=success&season=".$_GET['season']);
