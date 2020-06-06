<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'autoloader.inc.php';

$userCtrl = new UserCtrl();

$username = $_POST['username'];
$email = $_POST['email'];
$pwd = $_POST['passwd'];
$pwdrpt = $_POST['passwdrpt'];

echo $username . $email . $pwd . $pwdrpt;
