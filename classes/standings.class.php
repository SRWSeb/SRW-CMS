<?php

class Standings {
  public $season = array();
  public $rounds = array();
  public $standings = array();
  public $disqualified = array();

  private static function standings_sort($a, $b) {
    if($a["total_pts"] == $b["total_pts"]) return 0;
    return ($a["total_pts"] < $b["total_pts"])?1:-1;
  }

  public function loadStandings($seasonID) {
    //Load relevant Season
    $s = new Season();
    $s->seasonbyID($seasonID);

    //Populate Season Info
    $this->season = $s->getSeasonInfo();

    //Populate Rounds
    for ($i=1; $i <= $this->season['rounds']; $i++) {
      $round = 'Round '.$i;
      array_push($this->rounds, $round);
    }

    //Populate Standings
    foreach ($s->getSeasonDriverInfo() as $key => $value) {
      //first if it is an active driver
      if($value['active'] == 1) {
        //Get basic info per driver
        $this->standings[$key]['name'] = $value['display_name'];
        $this->standings[$key]['driverID'] = $value['driver_id'];
        $this->standings[$key]['class'] = $value['driver_class'];
        $this->standings[$key]['car'] = $value['car_name'];
        $this->standings[$key]['total_inc'] = 0;
        $this->standings[$key]['total_pts'] = 0;
        $this->standings[$key]['rounds'] = array();

        //get points and incidents per driver
        $t = new Transactions();
        $pts_transactions = $t->getPtsTransactionsForSeason($seasonID, $this->standings[$key]['driverID']);
        $inc_transactions = $t->getIncTransactionsForSeason($seasonID, $this->standings[$key]['driverID']);

        //build array for each round
        for ($i=0; $i < $this->season['rounds'] ; $i++) {
          $round = $i;
          $this->standings[$key]['rounds'][$round] = array();
          $this->standings[$key]['rounds'][$round]['pts'] = 0;
          $this->standings[$key]['rounds'][$round]['text-color'] = 'black';
        }

        //Populate each round and total points
        foreach ($pts_transactions as $pts_key => $pts_value) {
          $round = $pts_value['round_num'] - 1;

          $this->standings[$key]['rounds'][$round]['pts'] += $pts_value['pts_amount'];
          $this->standings[$key]['total_pts'] += $pts_value['pts_amount'];
        }

        //Add up all inc and put them in Standings
        foreach ($inc_transactions as $inc_key => $inc_value) {
          $this->standings[$key]['total_inc'] += $inc_value['inc_amount'];
        }

        //Check Inc limit, calculate threshold and set inc background color.
        $inclimit = $this->season['inc_limit'];
        if($inclimit > 0) {
          if($this->standings[$key]['total_inc'] < $inclimit*.7)
            $this->standings[$key]['inc_color'] = '#33cc33';
          else if ($this->standings[$key]['total_inc'] >= $inclimit*.7 && $this->standings[$key]['total_inc'] <= $inclimit)
              $this->standings[$key]['inc_color'] = '#ff9900';
          else if ($this->standings[$key]['total_inc'] > $inclimit)
            $this->standings[$key]['inc_color'] = '#ff0000';
        } else {
          $this->standings[$key]['inc_color'] = 'gray';
        }

      //then if it is an disqualied driver
      } else if($value['active'] == 2) {
        //Get basic info per driver
        $this->disqualified[$key]['name'] = $value['display_name'];
        $this->disqualified[$key]['driverID'] = $value['driver_id'];
        $this->disqualified[$key]['class'] = $value['driver_class'];
        $this->disqualified[$key]['car'] = $value['car_name'];
        $this->disqualified[$key]['total_inc'] = 0;
        $this->disqualified[$key]['total_pts'] = 0;
        $this->disqualified[$key]['rounds'] = array();

        //get points and incidents per driver
        $t = new Transactions();
        $pts_transactions = $t->getPtsTransactionsForSeason($seasonID, $this->disqualified[$key]['driverID']);
        $inc_transactions = $t->getIncTransactionsForSeason($seasonID, $this->disqualified[$key]['driverID']);

        //build array for each round
        for ($i=0; $i < $this->season['rounds'] ; $i++) {
          $round = $i;
          $this->disqualified[$key]['rounds'][$round] = array();
          $this->disqualified[$key]['rounds'][$round]['pts'] = 0;
          $this->disqualified[$key]['rounds'][$round]['text-color'] = 'black';
        }

        //Populate each round and total points
        foreach ($pts_transactions as $pts_key => $pts_value) {
          $round = $pts_value['round_num'] - 1;

          $this->disqualified[$key]['rounds'][$round]['pts'] += $pts_value['pts_amount'];
          $this->disqualified[$key]['total_pts'] += $pts_value['pts_amount'];
        }

        //Add up all inc and put them in Standings
        foreach ($inc_transactions as $inc_key => $inc_value) {
          $this->disqualified[$key]['total_inc'] += $inc_value['inc_amount'];
        }

        //Inc limit doesn't matter once DQed.
        $this->disqualified[$key]['inc_color'] = 'gray';
      }

      //If the championship has drop scores, find out how many, identify them and subtract them from the overall score
      /*$numdropscores = $this->season['drop_scores'];
      $roundscompleted = 2;
      if ($numdropscores > 0) {
        $scores = array();

        for ($i=0; $i < $roundscompleted; $i++) {
          $scores[$i] = $this->standings[$key]['rounds'][$i]['pts'];
        }

        sort($scores, SORT_NUMERIC);

        for ($i=0; $i < $numdropscores; $i++) {
          $this->standings[$key]['total_pts'] -= $scores[$i];
        }
      }*/

    }

    //Sort driverStandings by total points
    usort($this->standings, array('Standings','standings_sort'));

    //Add ranks
    foreach ($this->standings as $key => $value) {
      $this->standings[$key]['position'] = $key+1;
    }

    return true;
  }

}
