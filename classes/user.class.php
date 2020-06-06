<?php

class User extends Dbc {

  public function getUserbyName($username) {
      $sql = "SELECT * FROM users WHERE username = ?";
      $this->connect();
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([$username]);

      $results = $stmt->fetchAll();
      return $results;
  }

  public function getUserbyID($id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);

    $results = $stmt->fetchAll();
    return $results;
  }

  public function createUser($username, $email, $pwdhash) {
    $sql = "INSERT INTO users (username, email, pwd) VALUES (?, ?, ?)";
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$username, $email, $pwdhash]);

    return $this->conn->lastInsertId();
  }
}
