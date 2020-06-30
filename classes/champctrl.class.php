<?php

class ChampCtrl {

  public function buildLeaguesArray() {
    $league = new League();
    $leagueSeasons = $league->getLeagueSeasons();

    $leagueArray = array();
    $i = 0;

    foreach ($leagueSeasons as $key => $value) {
      $leagueArray[$value['season_id']] = $value['league_name'].' '.$value['season_name'];
      $i++;
    }
    return $leagueArray;
  }

  public function getSeasonInfo($seasonID) {
    $season = new Season();
    $season->seasonbyID($seasonID);
    return $season->getSeasonInfo();
  }

  public function buildDriverStandings($seasonID) {
    $season = new Season();
    $season->seasonbyID($seasonID);
    $seasonInfo = $season->getSeasonInfo();
    $rounds = $seasonInfo['rounds'];
    $drop_scores = $seasonInfo['drop_scores'];
    $seasonDriverInfo = $season->getSeasonDriverInfo();

    $driverStandings = array();

    foreach ($seasonDriverInfo as $key => $value) {
      $driverStandings[$key]['name'] = $value['display_name'];
      $driverStandings[$key]['driverID'] = $value['driver_id'];
      $driverStandings[$key]['class'] = $value['driver_class'];
      $driverStandings[$key]['car'] = $value['car_name'];
      $driverStandings[$key]['total_inc'] = $value['driver_inc_pts'];
      $driverStandings[$key]['total_pts'] = 0;

      $transactions = new Transactions();
      $rounds_transactions = $transactions->getPtsTransactionsForSeason($seasonID, $value['driver_id']);

      for ($i=1; $i <= $rounds ; $i++) {
        $round = 'Round '.$i;

        if (!isset($rounds_transactions[0])) {
          $driverStandings[$key][$round] = 0;
        } else {
          if ($rounds_transactions[0]['round_num'] == $i) {
            $driverStandings[$key][$round] = $rounds_transactions[0]['pts_amount'];
            $driverStandings[$key]['total_pts'] += $rounds_transactions[0]['pts_amount'];
            array_shift($rounds_transactions);
          } else {
            $driverStandings[$key][$round] = 0;
          }
        }
      }
    }

    return $driverStandings;
  }

  public function buildDriverTransactions($seasonID, $driverID) {
    $incTransactions = new Transactions();
    return $incTransactions->getIncTransactionsForSeason($seasonID, $driverID);
  }


}
