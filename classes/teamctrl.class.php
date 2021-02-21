<?php

class TeamCtrl {
  private $team;

  public static function getAllTeams() {
    $t = new Team();
    return $t->getAllTeams();
  }

  public function __construct() {
    $this->team = new Team();
  }

  public function addTeam($team_name) {
    if(!$this->team->getTeambyName($team_name)) {
      $this->team->createTeam($team_name);
      return 1;
    } else {
      return 0;
    }
  }

  public function getTeamInfo($teamID) {
    $this->team->getTeambyID($teamID);
    var_export($this->team);
  }

}
