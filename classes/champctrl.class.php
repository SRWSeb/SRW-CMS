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

  public function buildDriverStandings($seasonID) {
    $season = new Season();

    $seasonInfo = $season->getSeasonInfo($seasonID);
    $rounds = $seasonInfo[0]['rounds'];
    $drop_scores = $seasonInfo[0]['drop_scores'];
    $seasonDriverInfo = $season->getSeasonDriverInfo($seasonID);

    $driverStandings = array();

    foreach ($seasonDriverInfo as $key => $value) {
      $driverStandings[$key]['name'] = $value['display_name'];
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


}
