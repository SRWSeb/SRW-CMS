<?php
require "header.php";
?>

<main>
  <div class="container-fluid">
    <?php
      $champCtrl = new ChampCtrl();
      $champView = new ChampView();
      $driverName = DriverCtrl::getDriverNamebyID($_GET['id']);
      $incTransactions = $champCtrl->buildDriverTransactions($_GET['season'], $_GET['id']);
      $champView->buildDriverSite($incTransactions, $driverName);
    ?>
  </div>
</main>

<?php
require "footer.php";
?>
