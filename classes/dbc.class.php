<?php

class Dbc {
  private $host = "localhost";
  private $user = "root";
  private $pwd = "root";
  private $dbname = "srw_champ";
  
  protected $conn = NULL;

  protected function connect() {
    $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;

    $this->conn = new PDO($dsn, $this->user, $this->pwd);
    $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }
}
