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

    if (!isset($_GET['season'])) {
      $champView->leagueSelect($leagueArray);
    }

    if(isset($_GET['season'])) {
      $classes = ChampCtrl::getClasses();

      $s = new Standings();
      $s->loadStandings($_GET['season']);

      $champView->buildStandings($s, $classes);

      /*$seasonInfo = $champCtrl->getSeasonInfo($_GET['season']);
      $standings = $champCtrl->buildDriverStandings($_GET['season']);

      function standings_sort($a, $b) {
        if($a["total_pts"] == $b["total_pts"]) return 0;
        return ($a["total_pts"] < $b["total_pts"])?1:-1;
      }
      usort($standings, "standings_sort");

      $champView->buildChampTable($seasonInfo, $standings, $classes);*/
    }

    ?>
  </div>
</main>

<?php
require "footer.php";
?>
