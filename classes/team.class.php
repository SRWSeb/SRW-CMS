<?php

class Team extends Dbc {
  private $team = array();

  public function createTeam($team_name) {
    $sql = 'INSERT INTO teams (team_name) VALUES (?)';
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$team_name]);

    return $this->conn->lastInsertId();
  }

  public function getAllTeams() {
    $sql = 'SELECT * FROM teams ORDER BY team_name ASC';
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function getTeambyName($team_name) {
    $sql = 'SELECT * FROM teams WHERE team_name = ?';
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$team_name]);

    $this->team = $stmt->fetchAll();
    if(empty($this->team)) {
      return 0;
    }
    return 1;
  }

  public function getTeambyID($team_id) {
    $sql = 'SELECT * FROM teams WHERE id = ?';
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$team_id]);

    $this->team = $stmt->fetchAll();
    if(empty($this->team)) {
      return 0;
    }
    return 1;
  }

  public function assignDriver($team_id, $driver_id) {
    $sql = 'INSERT INTO team_driver (team_id, driver_id) VALUES (?, ?)';
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$team_id, $driver_id]);

    return 1;
  }

  public function assignDriverSeason($team_id, $driver_id, $season_id) {
    $sql = 'INSERT INTO team_driver_season (team_id, driver_id, season_id) VALUES (?, ?, ?)';
    $this->connect();
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$team_id, $driver_id, $season_id]);

    return 1;
  }
}
