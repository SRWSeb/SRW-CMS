<?php

class UserCtrl {

  public function registerUser($username, $email, $pwd, $pwdrepeat) {
    if($pwd != $pwdrepeat) {
      return "Password mismatch";
    }

    $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);

    $user = new User();
    $id = $user->createUser($username, $email, $pwdhash);
    return $id;
  }
}
