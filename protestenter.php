<?php
require 'header.php';
$view = new ProtestView();
?>

<div class="container">

  <?php
  if(!isset($_GET['season'])) {

    $leagueArray = ChampCtrl::buildLeaguesArray();
    $view->selectSeason($leagueArray);

  } else {

    if(isset($_GET['protest']) && $_GET['protest'] == 'success') {
      $view->protestSaved();
    }

    $champCtrl = new ChampCtrl();
    $driverlist = $champCtrl->getSeasonDrivers($_GET['season']);
    $roundslist = $champCtrl->getSeasonRounds($_GET['season']);
    $view->enterProtest($_GET['season'], $driverlist, $roundslist);

  }
   ?>

</div>

<?php
require 'footer.php';
?>
