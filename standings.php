<?php
require "header.php";
require 'includes/dbh.inc.php';
?>
<main>
  <div class="container-fluid">
    <?php
    $champCtrl = new ChampCtrl();
    $season = new Season();
    $champView = new ChampView();

    $leagueArray = $champCtrl->buildLeaguesArray();

    $champView->leagueSelect($leagueArray);

    if(isset($_GET['season'])) {

      $seasonInfo = $season->getSeasonInfo($_GET['season']);
      $standings = $champCtrl->buildDriverStandings($_GET['season']);

      function standings_sort($a, $b) {
        if($a["total_pts"] == $b["total_pts"]) return 0;
        return ($a["total_pts"] < $b["total_pts"])?1:-1;
      }
      usort($standings, "standings_sort");

      $champView->buildChampTable($seasonInfo[0]['rounds'], $standings);
    }

    ?>
  </div>
</main>

<?php
require "footer.php";
?>
