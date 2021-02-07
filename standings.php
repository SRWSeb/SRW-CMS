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
      if(isset($_GET['scope']))
        $s->loadStandings($_GET['season'], $_GET['scope']);
      else
        $s->loadStandings($_GET['season']);


      $champView->buildStandings($s, $classes);

    }

    ?>
  </div>
</main>

<?php
require "footer.php";
?>
