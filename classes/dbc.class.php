<?php

class Dbc {
  private $host = "";
  private $user = "";
  private $pwd = "";
  private $dbname = "";
  
  protected $conn = NULL;

  protected function connect() {
    $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;

    $this->conn = new PDO($dsn, $this->user, $this->pwd);
    $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }
}
