<?php

class League extends Dbc {

  public function getLeagueSeasons() {
    $sql = "SELECT leagues_seasons.*, seasons.season_name, leagues.league_name  FROM leagues_seasons
    JOIN seasons ON leagues_seasons.season_id = seasons.id
    JOIN leagues ON leagues_seasons.league_id = leagues.id";

    $this->connect();

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll();
    return $results;
  }
}
