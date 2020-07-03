<?php
require 'header.php';
$view = new AdminView();
?>

<div class="container-fluid">

  <?php
    $leagueArray = ChampCtrl::buildLeaguesArray();
    $view->leagueSelect($leagueArray);

    if (isset($_GET['season'])) {
      $driverArray = array();
      $view->buildDriverEdit($driverArray);
    }
  ?>


</div>

<?php
require 'footer.php';
?>
