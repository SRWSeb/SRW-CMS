<?php
require 'header.php';
$view = new AdminView();
$champCtrl = new ChampCtrl();
?>

<div class="container-fluid">

  <?php
    $leagueArray = ChampCtrl::buildLeaguesArray();
    $view->leagueSelect($leagueArray);

    if (isset($_GET['season']) && !isset($_GET['edit'])) {
      $driverArray = $champCtrl->getSeasonDrivers($_GET['season']);
      $view->buildDriverList($driverArray);
    } elseif (isset($_GET['edit'])) {
      $driverCtrl = new DriverCtrl();
      $driverInfo = $driverCtrl->getDriverSeasonInfos($_GET['edit'], $_GET['season']);
      var_export($driverInfo[0]);
      echo "<br>";
      $view->buildDriverEdit($driverInfo[0]);
    }
  ?>


</div>

<?php
require 'footer.php';
?>
