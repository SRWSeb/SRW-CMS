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
      $driverStandings[$key]['total_inc'] = 0;
      $driverStandings[$key]['total_pts'] = 0;

      $transactions = new Transactions();
      $rounds_pts_transactions = $transactions->getPtsTransactionsForSeason($seasonID, $value['driver_id']);
      $rounds_inc_transactions = $transactions->getIncTransactionsForSeason($seasonID, $value['driver_id']);

      //Sum up all Championship points accrued
      for ($i=1; $i <= $rounds ; $i++) {
        $round = 'Round '.$i;

        if (!isset($rounds_pts_transactions[0])) {
          $driverStandings[$key][$round] = 0;
        } else {
          if ($rounds_pts_transactions[0]['round_num'] == $i) {
            $driverStandings[$key][$round] = $rounds_pts_transactions[0]['pts_amount'];
            $driverStandings[$key]['total_pts'] += $rounds_pts_transactions[0]['pts_amount'];
            array_shift($rounds_pts_transactions);
          } else {
            $driverStandings[$key][$round] = 0;
          }
        }


      }

      //Sum up all Incidents accrued
      foreach ($rounds_inc_transactions as $inc_key => $inc_value) {
        $driverStandings[$key]['total_inc'] += $inc_value['inc_amount'];
      }
    }

    return $driverStandings;
  }

  public function buildDriverTransactions($seasonID, $driverID) {
    $incTransactions = new Transactions();
    return $incTransactions->getIncTransactionsForSeason($seasonID, $driverID);
  }


}
