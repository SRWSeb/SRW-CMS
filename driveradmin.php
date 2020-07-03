<?php
require 'header.php';
$view = new AdminView();
?>

<div class="container-fluid">

  <?php
    $leagueArray = ChampCtrl::buildLeaguesArray();
    $view->leagueSelect($leagueArray);

    if (isset($_GET['season'])) {
      echo "Blurp";
    }
  ?>


</div>

<?php
require 'footer.php';
?>
