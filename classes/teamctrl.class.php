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
    if(!$this->team->loadTeambyName($team_name)) {
      $this->team->createTeam($team_name);
      return 1;
    } else {
      return 0;
    }
  }

  public function getTeamInfo($teamID) {
    $this->team->loadTeambyID($teamID);
    $teaminfo['team_name'] = $this->team->getTeamName();
    $teaminfo['created'] = $this->team->getTeamCreated();
    $teaminfo['drivers'] = $this->team->getassignedDriver($teamID);
    
    return $teaminfo;
  }

}
