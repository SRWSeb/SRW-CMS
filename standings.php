<?php
require "header.php";
?>
<main>
  <div class="container-fluid">
    <?php
    $champCtrl = new ChampCtrl();
    $champView = new ChampView();

    $leagueArray = ChampCtrl::buildLeaguesArray();

    $champView->leagueSelect($leagueArray);

    if(isset($_GET['season'])) {

      $seasonInfo = $champCtrl->getSeasonInfo($_GET['season']);
      $standings = $champCtrl->buildDriverStandings($_GET['season']);

      function standings_sort($a, $b) {
        if($a["total_pts"] == $b["total_pts"]) return 0;
        return ($a["total_pts"] < $b["total_pts"])?1:-1;
      }
      usort($standings, "standings_sort");

      $champView->buildChampTable($seasonInfo, $standings);
    }

    ?>
  </div>
</main>

<?php
require "footer.php";
?>
