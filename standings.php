<?php
require "header.php";
?>
<main>
  <div class="container-fluid">
    <?php
    $champCtrl = new ChampCtrl();
    $champView = new ChampView();

    $leagueArray = ChampCtrl::buildLeaguesArray();
    $classes = ChampCtrl::getClasses();

    $champView->leagueSelect($leagueArray);

    if(isset($_GET['season'])) {

      $seasonInfo = $champCtrl->getSeasonInfo($_GET['season']);
      $standings = $champCtrl->buildDriverStandings($_GET['season']);
      $rounds = array( "rounds" => array());

      function standings_sort($a, $b) {
        if($a["total_pts"] == $b["total_pts"]) return 0;
        return ($a["total_pts"] < $b["total_pts"])?1:-1;
      }
      usort($standings, "standings_sort");

      for ($i=1; $i <= $seasonInfo['rounds']; $i++) {
        $round = 'Round '. $i;
        array_push($rounds['rounds'], $round);
      }
      
      $champView->buildChampTable($seasonInfo, $standings, $classes);
      //echo $m->render('standings', $rounds);

    }

    ?>
  </div>
</main>

<?php
require "footer.php";
?>
