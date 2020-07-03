<?php
require 'header.php';
$view = new AdminView();
$champCtrl = new ChampCtrl();
?>

<div class="container-fluid">

  <?php
    $leagueArray = ChampCtrl::buildLeaguesArray();
    $view->leagueSelect($leagueArray);
    $classes = ChampCtrl::getClasses();

    if (isset($_GET['season']) && !isset($_GET['edit'])) {

      $driverArray = $champCtrl->getSeasonDrivers($_GET['season']);
      $view->buildDriverList($driverArray, $classes);

    } elseif (isset($_GET['edit'])) {

      $driverCtrl = new DriverCtrl();
      $cars = ChampCtrl::getCars($_GET['season']);
      $driverInfo = $driverCtrl->getDriverSeasonInfos($_GET['edit'], $_GET['season']);
      $view->buildDriverEdit($driverInfo[0], $cars, $classes, $_GET['season']);

    }
  ?>


</div>

<?php
require 'footer.php';
?>
