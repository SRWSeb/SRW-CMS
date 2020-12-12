<?php
  require "header.php";

  class Standings {
    public $season = array();
    public $rounds = array();
    public $standings = array();
    public $disqualified = array();

    public function __construct() {

      $args = func_get_args();
      var_export($args);

      /*for ($i=1; $i <= $seasonInfo['rounds']; $i++) {
        $round = 'Round '. $i;
        array_push($this->rounds, $round);
      }

      $this->standings = array(
        0 => array('position' => '1', 'name' => 'Johnny Verhoeff', 'driverID' => '66', 'class' => '0', 'car' => 'Ford GTE', 'total_inc' => 0, 'inc_color' => '#33cc33', 'total_pts' => 185, 'active' => '1', 'rounds' => array(80,105,0,0,0,0,0,0,0,0) ),
        1 => array('position' => '2', 'name' => 'Bram van Putten', 'driverID' => '64', 'class' => '1', 'car' => 'BMW M8 GTE', 'total_inc' => 13, 'inc_color' => '#ff9900','total_pts' => 180, 'active' => '1', 'rounds' => array(90,90,0,0,0,0,0,0,0,0) )
      );

      $this->disqualified = array(
        0 => array('name' => 'Rutger Wijnen', 'driverID' => '66', 'class' => '0', 'car' => 'Ford GTE', 'total_inc' => 0, 'inc_color' => '#33cc33', 'total_pts' => 185, 'active' => '1', 'rounds' => array(80,105,0,0,0,0,0,0,0,0) ),
        1 => array('name' => 'Jeromy Hessels', 'driverID' => '64', 'class' => '1', 'car' => 'BMW M8 GTE', 'total_inc' => 13, 'inc_color' => '#ff9900','total_pts' => 180, 'active' => '1', 'rounds' => array(90,90,0,0,0,0,0,0,0,0) )
      );

      $this->season = array(
        'league_name' => $seasonInfo['league_name'],
        'season_id' => $seasonInfo['id'],
        'season_name' => $seasonInfo['season_name']
      );*/

    }

    public function loadSeason($seasonID) {
      for ($i=1; $i <= 10; $i++) {
        $round = 'Round '. $i;
        array_push($this->rounds, $round);
      }

      $this->standings = array(
        0 => array('position' => '1', 'name' => 'Johnny Verhoeff', 'driverID' => '66', 'class' => '0', 'car' => 'Ford GTE', 'total_inc' => 0, 'inc_color' => '#33cc33', 'total_pts' => 185, 'active' => '1', 'rounds' => array(80,105,0,0,0,0,0,0,0,0) ),
        1 => array('position' => '2', 'name' => 'Bram van Putten', 'driverID' => '64', 'class' => '1', 'car' => 'BMW M8 GTE', 'total_inc' => 13, 'inc_color' => '#ff9900','total_pts' => 180, 'active' => '1', 'rounds' => array(90,90,0,0,0,0,0,0,0,0) )
      );

      $this->disqualified = array(
        0 => array('name' => 'Rutger Wijnen', 'driverID' => '66', 'class' => '0', 'car' => 'Ford GTE', 'total_inc' => 0, 'inc_color' => '#33cc33', 'total_pts' => 185, 'active' => '1', 'rounds' => array(80,105,0,0,0,0,0,0,0,0) ),
        1 => array('name' => 'Jeromy Hessels', 'driverID' => '64', 'class' => '1', 'car' => 'BMW M8 GTE', 'total_inc' => 13, 'inc_color' => '#ff9900','total_pts' => 180, 'active' => '1', 'rounds' => array(90,90,0,0,0,0,0,0,0,0) )
      );

      $this->season = array(
        'league_name' => 'Simracersworld GT Series',
        'season_id' => 3,
        'season_name' => 'PRO Season 7'
      );
    }


  }


  $champCtrl = new ChampCtrl();
  $seasonInfo = $champCtrl->getSeasonInfo($_GET['season']);
  $s = new Standings($seasonInfo);
  $s->loadSeason(3);

  echo $m->render('standings', $s);

  require "footer.php";
?>
