<?php

class UserCtrl {

  public function registerUser($username, $email, $pwd, $pwdrepeat) {

    $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);

    $user = new User();
    $row = $user->getUserbyName($username);
    if(empty($row)) {
      $id = $user->createUser($username, $email, $pwdhash);
      return true;
    }
    return false;
  }

  public function loginUser($username, $pwd) {
    $user = new User();
    $userdata = $user->getUserbyName($username);
    if (!isset($userdata[0])) {
      return false;
    } elseif (!password_verify($pwd, $userdata[0]['pwd'])) {
      return false;
    } else {
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      return true;
    }
  }

}
