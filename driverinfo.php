<?php
require "header.php";
?>

<main>
  <div class="container-fluid">
    <?php
      $champCtrl = new ChampCtrl();
      $champView = new ChampView();
      $incTransactions = $champCtrl->buildDriverTransactions($_GET['season'], $_GET['id']);
      $champView->buildDriverSite($incTransactions);
    ?>
  </div>
</main>

<?php
require "footer.php";
?>
